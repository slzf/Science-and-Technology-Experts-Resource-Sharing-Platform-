<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
/**
 * 不需要认证的路由
 */
//专家相关
//获得专家列表
Route::get('expertList','expertController@getexpertList');
//获得某个专家的所有信息
Route::get('expertInfo','expertController@getexpertInfo');

//论文
//获得论文列表
Route::get('paperList','paperController@getPaperList');
//获得某篇论文的所有信息
Route::get('paperInfo','paperController@getPaperInfo');
//获得某篇论文的相似论文
Route::get('similarPaper','paperController@getSimilarPaper');


//高级搜索
Route::get('advancedSearch','paperController@advancedSearch');

//专利
//获得专利列表
Route::get('patentList','patentController@getPatentList');
//获得某个专利的所有信息
Route::get('patentInfo','patentController@getPatentInfo');

# 401 登录
Route::post('/user/login', 'userController@login');
//注意：form代码里应该包含csrf令牌 {{ csrf_field() }}
# 注册
Route::post('/user/signup', 'userController@signup');

Route::get('testData', function () {
    return view('testData');
});

//是否登陆
Route::get('/checkLogin', function () {
    if(session('user'))
        return response(['status'=>1]);
    return response(['status'=>0]);
});


/**
 * 舍弃或者重定向的路由：
 * /history/request/submit -> /applyFull
 *
 */



/**
 * 需要认证的路由 'middleware'=>'checkLogin'
 */
Route::group([],function ()
{
    #注销
    Route::get('/logout', 'userController@logout');

    #任务系统
    Route::get('/task', 'user_taskController@getTaskbyUser');
    Route::post('/task/receiveCredit', 'userController@reveiveCredit');
    Route::get('/history/browsing', 'historyController@getHistorybyUser');
    Route::post('/history/browsing/submit', 'historyController@setHistorybyUser');
    Route::get('/history/request', 'historyController@getApplybyUser');

    //申请论文全文
    Route::post('applyFull','paperApplyController@applyFull');

    //反馈
    //提交反馈
    Route::post('submitFeedback','feedbackController@submitFeedback');

    //积分
    //积分历史消费情况
    Route::get('integralUseHistory','integralController@getConsumeHistoryList');
    //购买积分
    Route::post('buyIntegral','integralController@buyIntegral');
    //购买历史记录
    Route::get('purchaseHistory','orderController@getPurchaseHistoryList');

    //个人资料
    //查看个人资料
    Route::get('profile','userController@getProfile');
    Route::post('modProfile','userController@modProfile');

    #查看用户收藏夹
    Route::get('/collection', 'collectionController@viewFolder');
    #查看收藏的专家
    Route::get('/collection/expert', 'collectionController@viewExpert');
    #查看收藏的论文
    Route::get('/collection/paper', 'collectionController@viewPaper');
    #查看收藏的专利
    Route::get('/collection/patent', 'collectionController@viewPatent');
    #查看其他收藏夹
    Route::get('/collection/other', 'collectionController@viewOther');
    #新建收藏夹
    Route::post('/collection/dir/new', 'collectionController@newFolder');
    #删除收藏夹
    Route::post('/collection/dir/del', 'collectionController@delFolder');
    #重命名收藏夹
    Route::post('/collection/dir/rename', 'collectionController@renameFolder');

    #收藏
    #新建
    Route::post('/collection/item/new', 'collectionController@newItem');
    #删除
    Route::post('/collection/item/del', 'collectionController@delItem');
    #重命名
    Route::post('/collection/item/rename', 'collectionController@renameItem');
    #移动
    Route::post('/collection/item/move', 'collectionController@moveItem');
    #下载
    Route::get('/download', 'paperController@download');

    # 201 提交认证信息
    Route::post('/user/authentication', 'authExamingController@addAuthentication');

    //（专家）查看申请信息
    Route::get('expert/showApplyMessage', 'expertController@showPaperApply');

    //（专家）处理申请信息
    Route::post('expert/dealApplyMessage', 'expertController@dealPaperApply');

    //（专家）查看个人信息
    Route::get('expert/showInfo', 'expertController@showInfo');

    //（专家）修改个人信息
    Route::post('expert/modInfo', 'expertController@modInfo');

    //（专家）查看拥有的论文
    Route::get('expert/showPaper', 'expertController@showPaper');

    //（专家）查看拥有的专利
    Route::get('expert/showPatent', 'expertController@showPatent');

    //（专家）修改拥有的专利
    Route::post('expert/modPatent', 'expertController@modPatent');

    //（专家）添加拥有的专利
    Route::post('expert/addPatent', 'expertController@addPatent');





    //主页推荐专家
    Route::get('user/recommendExpert', 'userController@showRecommendExpert');

    //主页推荐专利
    Route::get('user/recommendPatent', 'userController@showRecommendPatent');

    //主页推荐论文
    Route::get('user/recommendPaper', 'userController@showRecommendPaper');

    //主页推荐关键词
    Route::get('user/recommendKeyword', 'userController@showRecommendKeyword');
});
/**
 * 暂时取消验证的
 */

//（管理员）查看认证列表
Route::get('admin/showAuthenticationList', 'adminController@showAuthenticationList');

//（管理员）查看认证
Route::get('admin/showAuthentication', 'adminController@showAuthentication');

//（管理员）审核认证
Route::post('admin/reviewAuthentication', 'adminController@reviewAuthentication');


//（管理员）查看反馈列表
Route::get('admin/showFeedbackList', 'adminController@showFeedbackList');

//（管理员）查看反馈详情
Route::get('admin/showFeedback', 'adminController@showFeedback');
