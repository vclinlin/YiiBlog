<?php
/**
 * Created by PhpStorm.
 * User: 17424
 * Date: 2018/5/20
 * Time: 21:57
 */

namespace frontend\widgets\hot;

use common\models\PostExtendsModel;
use yii\bootstrap\Widget;
use Yii;
use common\models\PostsModel;
use yii\helpers\Url;
use yii\db\Query;

class HotWidget extends Widget
{
    public $title = '';

    /**
     * 显示条数
     * @var unknown
     */
    public $limit =10;

    /**
     * 是否显示更多
     * @var unknown
     */
    public $more = true;

    /**
     * 是否显示分页
     * @var unknown
     */
    public $page = true;

    public function run()
    {
        $res = (new Query())
            ->select('a.browser, b.id, b.title')
            ->from(['a'=>PostExtendsModel::tableName()])
            ->join('LEFT JOIN',['b'=>PostsModel::tableName()],'a.post_id = b.id')
            ->where('b.is_valid ='.PostsModel::IS_VALID)
            ->orderBy(['browser'=>SORT_DESC,'id'=>SORT_DESC])
            ->limit($this->limit)
            ->all();

        $result['title'] = $this->title?:'热门浏览';
        $result['more'] = Url::to(['post/index','sort'=>'hot']);
        $result['body'] = $res?:[];

        return $this->render('index',['data'=>$result]);
    }
}