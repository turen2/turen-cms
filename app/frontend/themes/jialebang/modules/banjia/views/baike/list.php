<?php
/* @var $this yii\web\View */

use app\widgets\SideBoxListWidget;

?>
<div class="baike-content">
    <div class="container">
        <div class="banjia-title">
            <ul>
                <li><b>当前位置：</b></li>
                <li><a href="/">首页</a></li>
                <li><span>&gt;</span></li>
                <li><a href="">装修攻略</a></li>
                <li><span>&gt;</span></li>
                <li>装修文章列表</li>
            </ul>
        </div>
        <div class="banjia-box">
            <div class="banjia-left sidebox">
                <div class="banjia-manual">
                    <div class="banjia-manual-title">
                        <h3>搬家流程</h3>
                    </div>
                    <div class="banjia-manual-tab">
                        <ol>
                            <div class="flow-line"></div>
                            <li class="banjia-flow">
                                <div class="flow-left">
                                    <span></span><i>1</i>
                                </div>
                                <div class="flow-right">
                                    <p>线上咨询（预约阶段）</p>
                                    <p class="content">
                                        线上咨询线上咨询线上咨询线上咨询线上咨询
                                    </p>
                                </div>
                            </li>
                            <li class="banjia-flow">
                                <div class="flow-left">
                                    <span></span><i>2</i>
                                </div>
                                <div class="flow-right">
                                    <p>定制方案（规划阶段）</p>
                                    <p class="content">
                                        定制方案定制方案定制方案定制方案定制方案定制
                                    </p>
                                </div>
                            </li>
                            <li class="banjia-flow">
                                <div class="flow-left">
                                    <span></span><i>3</i>
                                </div>
                                <div class="flow-right">
                                    <p>上门服务（执行阶段）</p>
                                    <p class="content">
                                        上门服务上门服务上门服务上门服务上门服务
                                    </p>
                                </div>
                            </li>
                            <li class="banjia-flow">
                                <div class="flow-left">
                                    <span></span><i>4</i>
                                </div>
                                <div class="flow-right">
                                    <p>售后反馈（售后阶段）</p>
                                    <p class="content">
                                        售后反馈售后反馈售后反馈售后反馈售后反馈售
                                    </p>
                                </div>
                            </li>
                        </ol>
                    </div>
                </div>
                <?= SideBoxListWidget::widget([
                    'style' => 'gen',
                    'title' => '百科推荐',
                    'htmlClass' => 'baike-list',
                    
                    'columnType' => 'article',
                    'flagName' => '推荐',
                    'columnId' => 	Yii::$app->params['config_face_banjia_cn_sidebox_baike_column_id'],//搬家百科
                    'route' => '/banjia/baike/detail',
                ]); ?>
                <?= SideBoxListWidget::widget([
                    'style' => 'tab',
                    'htmlClass' => 'about-us',
                    'columnType' => 'block',
                    'blockId' => Yii::$app->params['config_face_banjia_cn_sidebox_contact_us_block_id'],
                ]); ?>
                <div class="aboutlabel">
                    <h3>相关标签</h3>
                    <ul>
                        <li><a href="" target="_blank">装修美图</a></li>
                        <li><a href="" target="_blank">学装修知识</a></li>
                        <li><a href="" target="_blank">找设计</a></li>
                        <li><a href="" target="_blank">装修报价早知道</a></li>
                        <li><a href="" target="_blank">我想自己设计</a></li>
                        <li><a href="" target="_blank">搜问答</a></li>
                        <li><a href="" target="_blank">精美图册</a></li>
                        <li><a href="" target="_blank">找小区案例</a></li>
                        <li><a href="" target="_blank">优秀设计师</a></li>
                        <li><a href="" target="_blank">找监理</a></li>
                    </ul>
                </div>
            </div>
            <div class="banjia-right">
                <div class="banjia-right-tab">
                    <ul>
                        <li class="banjia-choose"><a href="" rel="nofollow"><b>时间排序</b><span><img class="banjia-btm" src="https://statics.zxzhijia.com/zxzj2017/new2018/images/tobtm.png"><img src="https://statics.zxzhijia.com/zxzj2017/new2018/images/tobtm-color.png"></span></a>
                        </li>
                        <li><a href="" rel="nofollow"><b>热门排序</b><span><img class="banjia-btm" src="https://statics.zxzhijia.com/zxzj2017/new2018/images/tobtm.png"><img src="https://statics.zxzhijia.com/zxzj2017/new2018/images/tobtm-color.png"></span></a>
                        </li>
                    </ul>
                </div>
                <div class="banjia-right-box">
                    <ul>
                        <li class="banjia-list">
                            <span><a href=""><img src="https://img.zxzhijia.com/edpic/image/201901/20190107103054_14207.jpg"></a></span>
                            <div class="banjia-text">
                                <h5>
                                    <a class="textname" href="" target="_blank">新中式卧室，这才是专属中国人的风格</a>
                                    <ol>
                                        <li><a href="" target="_blank">装修知识</a></li>
                                        <li><a href="" target="_blank">新中式风格</a></li>
                                    </ol>
                                </h5>
                                <p>别墅设计新中式风格作为一种在中国新兴的设计风格，它格调高雅、平和内敛、古朴端庄，展现出中国传统文化的深厚底蕴！</p>
                                <dl>
                                    <dd><i class="fa fa-clock-o"></i><b>01月07日 11:21</b></dd>
                                    <dd><i class="fa fa-eye"></i><b style="color: #888;">857</b></dd>
                                </dl>
                            </div>
                        </li>
                        <li class="banjia-list">
                            <span><a href=""><img src="https://img.zxzhijia.com/edpic/image/201901/20190107103025_78658.jpg"></a></span>
                            <div class="banjia-text">
                                <h5>
                                    <a class="textname" href="" target="_blank">新中式遇上高级灰，这样搭才是顶配！</a>
                                    <ol>
                                        <li><a href="" target="_blank">装修知识</a></li>
                                        <li><a href="" target="_blank">别墅</a></li>
                                    </ol>
                                </h5>
                                <p>
                                    纯粹的黑白灰作为空间主色出现，旨在烘托出一种文雅与风度，墨色的背景墙透过月洞门，又宛如远山萦绕，言有尽，而意无声。这种引景入室的手法，可以令室内与室外产生良好的互动，呈现出‘顾盼有景，游之不厌’的生动画面。</p>
                                <dl>
                                    <dd><i class="fa fa-clock-o"></i><b>01月07日 11:20</b></dd>
                                    <dd><i class="fa fa-eye"></i><b style="color: #888;">888</b></dd>
                                </dl>
                            </div>
                        </li>
                        <li class="banjia-list">
                            <span><a href=""><img src="https://img.zxzhijia.com/edpic/image/201901/20190106101407_86646.png"></a></span>
                            <div class="banjia-text">
                                <h5>
                                    <a class="textname" href="" target="_blank">现代主义，演绎大气时尚年轻活力姿态！</a>
                                    <ol>
                                        <li><a href="" target="_blank">装修知识</a></li>
                                        <li><a href="" target="_blank">现代简约风</a></li>
                                    </ol>
                                </h5>
                                <p>
                                    现代家居装修设计，注重功能，是当下人们追求的居家理念，简约大气的感觉，不要繁琐的设计，色调温暖明亮。现代简约风格的设计相对于普通百姓来说，选择的会多一些，简约而不简单，实用大气，
                                    也能彰显出年轻的活力，现代风格的舒适简约，拥抱您那颗自由无拘、永远年轻的心。</p>
                                <dl>
                                    <dd><i class="fa fa-clock-o"></i><b>01月07日 10:29</b></dd>
                                    <dd><i class="fa fa-eye"></i><b style="color: #888;">888</b></dd>
                                </dl>
                            </div>
                        </li>
                        <li class="banjia-list">
                            <span><a href=""><img src="https://img.zxzhijia.com/edpic/image/201901/20190106100825_80091.png"></a></span>
                            <div class="banjia-text">
                                <h5>
                                    <a class="textname" href="" target="_blank">别墅设计东方之美，是传承也是创新！</a>
                                    <ol>
                                        <li><a href="" target="_blank">装修知识</a></li>
                                        <li><a href="" target="_blank">别墅设计</a></li>
                                    </ol>
                                </h5>
                                <p>
                                    别墅设计结合现代简约风格和传统中式风格，用各自的特点，来相互补充和完善，呈现出两者兼有。设计中减少中式风格的沉闷和简约风格的浮动，让空间稳中有动，简中有繁，体现业主对中国生活情调的追求。用富有中国特色的装饰和艺术来体现东方之美，通过一种简约的形式，呈现舒适温馨的居住环境。</p>
                                <dl>
                                    <dd><i class="fa fa-clock-o"></i><b>01月07日 10:28</b></dd>
                                    <dd><i class="fa fa-eye"></i><b style="color: #888;">888</b></dd>
                                </dl>
                            </div>
                        </li>
                        <li class="banjia-list">
                            <span><a href=""><img src="https://img.zxzhijia.com/edpic/image/201901/20190105120244_69008.jpg"></a></span>
                            <div class="banjia-text">
                                <h5>
                                    <a class="textname" href="" target="_blank">中式设计，越简约，越时尚</a>
                                    <ol>
                                        <li><a href="" target="_blank">装修知识</a></li>
                                        <li><a href="" target="_blank">别墅</a></li>
                                    </ol>
                                </h5>
                                <p>别墅座落在青山绿水间，返璞归真心，注定要追寻一场以东方文化为精髓的闲趣逸致生活。</p>
                                <dl>
                                    <dd><i class="fa fa-clock-o"></i><b>01月05日 13:35</b></dd>
                                    <dd><i class="fa fa-eye"></i><b style="color: #888;">888</b></dd>
                                </dl>
                            </div>
                        </li>
                        <li class="banjia-list">
                            <span><a href=""><img src="https://img.zxzhijia.com/edpic/image/201901/20190105120211_37186.jpg"></a></span>
                            <div class="banjia-text">
                                <h5>
                                    <a class="textname" href="" target="_blank">高品质尊贵别墅：绽放优雅与不羁</a>
                                    <ol>
                                        <li><a href="" target="_blank">装修知识</a></li>
                                        <li><a href="" target="_blank">别墅装修</a></li>
                                    </ol>
                                </h5>
                                <p>在四海为家的时代，昂扬的生活态度，是优雅与浪漫、狂放与绅士风度、过去与时尚潮流汇聚在一起的妙不可言。</p>
                                <dl>
                                    <dd><i class="fa fa-clock-o"></i><b>01月05日 13:19</b></dd>
                                    <dd><i class="fa fa-eye"></i><b style="color: #888;">888</b></dd>
                                </dl>
                            </div>
                        </li>
                        <li class="banjia-list">
                            <span><a href=""><img src="https://img.zxzhijia.com/edpic/image/201901/20190104110832_86296.jpg"></a></span>
                            <div class="banjia-text">
                                <h5>
                                    <a class="textname" href="" target="_blank">现代轻奢，让精致来的刚刚好</a>
                                    <ol>
                                        <li><a href="" target="_blank">装修知识</a></li>
                                        <li><a href="" target="_blank">现代极简主义</a></li>
                                    </ol>
                                </h5>
                                <p>设计师本次软装设计中解构流行与文化，突破风格界限，带着自我意识中对人文的理解和态度重新审视陈设艺术与生活百态。</p>
                                <dl>
                                    <dd><i class="fa fa-clock-o"></i><b>01月04日11:37</b></dd>
                                    <dd><i class="fa fa-eye"></i><b style="color: #888;">888</b></dd>
                                </dl>
                            </div>
                        </li>
                        <li class="banjia-list">
                            <span><a href=""><img src="https://img.zxzhijia.com/edpic/image/201901/20190104110759_92264.jpg"></a></span>
                            <div class="banjia-text">
                                <h5>
                                    <a class="textname" href="" target="_blank">轻奢时尚、恰到好处的精致！</a>
                                    <ol>
                                        <li><a href="" target="_blank">装修知识</a></li>
                                        <li><a href="" target="_blank">别墅装修</a></li>
                                    </ol>
                                </h5>
                                <p>
                                    对于年轻一族来说，豪奢不是最重要的，温暖、轻松、愉悦、充满生活气息的品质生活才是他们真正的需求所在。比起在视觉层面的迎合，适宜的大小、满足日常居住的功能性、舒适的空间氛围更能打动他们。</p>
                                <dl>
                                    <dd><i class="fa fa-clock-o"></i><b>01月04日 11:35</b></dd>
                                    <dd><i class="fa fa-eye"></i><b style="color: #888;">888</b></dd>
                                </dl>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="banjia-page">
                    <a class="first" href="">首页</a>
                    <a class="pre" href="">上一页</a>
                    <ul>
                        <li><a href="">2</a></li>
                        <li><a href="">3</a></li>
                        <li><a href="" class="nov">4</a></li>
                        <li><a href="">5</a></li>
                        <li><a href="">6</a></li>
                        <li><a href="">7</a></li>
                    </ul>
                    <a class="next" href="">下一页</a>
                    <a class="last" href="">末页</a>
                </div>
            </div>
        </div>
    </div>
</div>
