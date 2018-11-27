<?php
namespace frontend\widgets\post;

use common\models\PostsModel;
use frontend\models\PostForm;
use yii\helpers\Url;
use yii\base\Widget;
use Yii;
use yii\data\Pagination;

class PostWidget extends Widget
{
    /**
     * @var string
     * 标题
     * 条数
     * 是否显示更多
     * 是否分页
     */
    public $title='';
    public $limit = 6;
    public $more = true;
    public $page = false;
    public function run()
    {
        $curPage = Yii::$app->request->get('page',1);
//        查询条件
        $coud = ['=','is_valid',PostsModel::IS_VALID];
//
        $res = PostForm::getList($coud,$curPage,$this->limit);
        $result['title'] = $this->title?:'最新文章';
        $result['more'] =Url::to(['post/index']);
        $result['body'] = $res['data']?:[];
//        是否分页
        if($this->page){
            $pages = new Pagination(['totalCount'=>$res['count'],'pageSize'=>$res['pageSize']]);
            $result['page']=$pages;
        }
        return $this->render('index',['data'=>$result]);
    }


}