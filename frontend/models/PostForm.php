<?php
/**
 * Created by PhpStorm.
 * User: 17424
 * Date: 2018/5/19
 * Time: 23:20
 * 文章表单模型
 */

namespace frontend\models;

use common\models\PostsModel;
use common\models\RelationPostTagsModel;
use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\web\NotFoundHttpException;

class PostForm extends Model
{
    public $id;
    public $title;
    public $content;
    public $label_img;
    public $cat_id;
    public $tags;

    public $_lastError="";
//定义场景    创建与更新
    const SCENARIOS_CREATE = 'create';
    const SCENARIOS_UPDATE = 'update';

    const EVENT_AFTER_CREATE ='eventAfterCreate';  //事间
    const EVENT_AFTER_UPDATE ='eventAfterUpdate';
//场景设置
    public function scenarios()
    {
        $scenarios = [
            self::SCENARIOS_CREATE=>['title','content','label_img','cat_id','tags'],
            self::SCENARIOS_UPDATE=>['title','content','label_img','cat_id','tags']
        ];
        return array_merge(parent::scenarios(),$scenarios);
    }

    public function rules()  //规则
    {
        return [
            [['id','title','content','cat_id'],'required'],
            [['id','cat_id'],'integer'],
            ['title','string','min'=>4,'max'=>50],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id'=>'编号',
            'title'=>'标题',
            'content'=>'内容',
            'label_img'=>'封面/配图:',
            'tags'=>'标签',
            'cat_id'=>'分类',
        ];
    }

    public function create(){
//        事务引用
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $model = new PostsModel();
            $model->setAttributes($this->attributes);
            $model->summary=$this->_getSummary();
            $model->user_id = Yii::$app->user->identity->id;
            $model->user_name = Yii::$app->user->identity->username;
            $model->is_valid= PostsModel::IS_VALID;
            $model->created_at = time();
            $model->updated_at = time();
            if(!$model->save())
            {
                throw new\Exception('文章保存失败');
            }
            $this->id = $model->id;
//            事件
            $data = array_merge($this->getAttributes(),$model->getAttributes());
            $this->_eventAfterCreate($data);
            $transaction->commit();
            return true;
        }catch (\Exception $e){
            $transaction->rollBack();
            $this->_lastError = $e->getMessage();
            return false;
        }
    }

    private function _getSummary($s = 0,$e = 90,$char ='utf-8'){
        if(empty($this->content))
        {
            return null;
        }
//        截取文章摘要
        return (mb_substr(str_replace('&nbsp;','',strip_tags($this->content)),$s,$e,$char));
    }
    public function _eventAfterCreate($data){
//        添加事件
    $this->on(self::EVENT_AFTER_CREATE,[$this,'_eventAddTag'],$data);
//    事件触发
        $this->trigger(self::EVENT_AFTER_CREATE);
    }
//添加标签
    public function _eventAddTag($event){
    $tag = new TagForm();  //保存标签
    $tag->tags = $event->data['tags'];
    $tagids = $tag->saveTags();

//    删除原先的关联
    RelationPostTagsModel::deleteAll(['post_id'=>$event->data['id']]);
//    批量保存
        if(!empty($tagids)){
            foreach ($tagids as $k=>$id){
                $row[$k]['post_id']=$this->id;
                $row[$k]['tag_id']=$id;
            }
//            批量插入
            $res = (new Query())->createCommand()
                ->batchInsert(RelationPostTagsModel::tableName(),['post_id','tag_id'],$row)
                ->execute();
            if(!$res)
            {
                throw new \Exception('关联关系保存失败');
            }
        }
    }
    public function getViewById($id){
        $res = PostsModel::find()->with('relate.tag','extend')
            ->where(['id'=>$id])->asArray()->one();
        if(!$res){
            throw new NotFoundHttpException('文章不存在');
        }
//        处理标签格式
        $res['tags']=[];
        if(isset($res['relate'])&& !empty($res['relate'])){
            foreach ($res['relate'] as $list)
            {
                $res['tags'][]=$list['tag']['tag_name'];
            }
        }
        unset($res['relate']);
        return $res;

    }
    public static function getList($cond,$curPage=1,$pageSize=5,$orderBy=['id'=>SORT_DESC])
    {
        $model = new PostsModel();
//        查询
        $select = ['id','title','summary','label_img','cat_id','user_id','user_name',
            'is_valid','created_at','updated_at'];
        $query = $model->find()->select($select)
            ->where($cond)->with('relate.tag','extend')
            ->orderBy($orderBy);
//        获取分页数据
        $res = $model->getPages($query,$curPage,$pageSize);
//        格式化
        $res['data']=self::_formatList($res['data']);
        return $res;
    }
    public static function _formatList($data)
    {
        foreach ($data as &$list)
        {
            $list['tags']=[];
            if(isset($list['relate']) && !empty($list['relate'])) {
                foreach ($list['relate'] as $lt)
                {
                    $list['tags'][]=$lt['tag']['tag_name'];
                }
            }
            unset($list['relate']);
        }
        return $data;
    }
}