<?php
/**
 * @link http://www.turen2.com/
 * @copyright Copyright (c) 土人开源CMS
 * @author developer qq:980522557
 */
$this->title = '关于我们';
$webUrl = Yii::getAlias('@web/');

$js = <<<EOF
$('.aboutnav li').on('click', function() {
    var i = $(this).index();
    $('.aboutnav li').removeClass('on').eq(i).addClass('on');
    $('.tabbox-content').hide().eq(i).show();
});
EOF;
$this->registerJs($js);
?>

<div class="about-us-banner"></div>
<div class="container">
    <div class="aboutnav">
        <ul>
            <li class="on">关于嘉乐邦</li>
            <li class="">加入我们</li>
        </ul>
    </div>
    <div class="tabbox">
        <div class="tabbox-content about-infor" style="display: block;">
            <p class="about-centent">嘉乐邦创立于2013年8月，是一家典型的“互联网+生活服务”平台，在成立之前就获得了雷军/顺为资本的天使投资，提供优质家庭生活服务和企业后勤服务，用户可以在线预约保洁服务、家电清洗、家居保养、保姆、月嫂、育儿嫂、老人陪护、除甲醛、搬家、维修安装、空气治理等服务，并覆盖了北京、上海、广州、深圳、杭州、成都、南京、西安、重庆等80多个城市。</p>
            <p class="about-centent">公司通过高频的保洁服务为入口打品牌，建立标准化的业务研究体系、培训体系和品控体系，并不断在供给侧进行创新改革，获得了良好的市场口碑和地位。2015年初，随着互联网家装及互联网公寓的兴起，公司正式进入企业服务市场，并陆续搭建了基于企业保洁为入口，企业养护服务、企业送水、绿植养护、企业用车等为辅的企业后勤一站式服务平台。公司技术团队实力雄厚，通过自主开发的智能调度系统有效的提高了阿姨及第三方商家的服务效率，阿姨平均每月比传统方式多挣30%以上。</p>
            <p>使命：</p>
            <p class="website-color">让家庭生活更美好</p>
            <p>我们专注地服务于注重生活品质的中高端人群，帮他们从繁杂的家务中解放出来，让他们有更多的时间去打拼事业，去陪伴家人。</p>
            <p class="website-color">让企业办公更愉悦</p>
            <p class="about-centent">我们致力于提高中小企业的后勤服务体验，提供更高品质、更高效率、更低成本的一站式整体服务，让企业后勤更高效，办公更愉悦。</p>
            <p>愿景：</p>
            <p>价值观：</p>
            <p class="website-color about-centent">必胜、激情、担当、坚持、团队合作、拥抱变化</p>

            <p>公司地址：深圳深圳深圳深圳深圳深圳深圳深圳深圳深圳</p>
            <p>客服电话：400-000-0000</p>
            <p>官方微信：jialebang100</p>
            <ul>
                <li>
                    <h4>市场及广告合作</h4>
                    <p>联系人：甘女士</p>
                    <p>邮箱：ayb_market#jialebang100.com</p>
                </li>
                <li>
                    <h4>服务人员输送合作</h4>
                    <p>联系人：张老师</p>
                    <p>邮箱：ayb_xa#jialebang100.com</p>
                </li>
                <li>
                    <h4>服务商接入合作</h4>
                    <p>联系人：马先生</p>
                    <p>邮箱：ayb_open#jialebang100.com</p>
                </li>
                <li>
                    <h4>产品及渠道合作</h4>
                    <p>联系人：Jason</p>
                    <p>邮箱：ayb_bd#jialebang100.com</p>
                </li>
            </ul>
        </div>
        <div class="tabbox-content add-ours" style="display: none;">
            <div class="addtop">
                <p>公司长期招聘出色并富有战斗力的手机开发攻城湿、PHP攻城湿、运维攻城湿、运营客服经理、市场推广经理等。</p>
                <p>有兴趣请发邮件至 <a href="mailto:ayb_hr@jialebang100.com">ayb_hr@jialebang100.com</a>，并注明申请职位名称。我们这帮家伙有多靠谱，只有你进来才知道。</p>
            </div>
            <div class="position">
                <div class="postinfor">
                    <div class="black"></div>
                    <div class="infors on">
                        <div class="abclose"></div>
                        <div class="infortitle">高级PHP开发工程师</div>
                        <div class="infortext">
                            <div class="texts">职位描述：</div>
                            <p>1、根据产品需求，独立完成项目的架构设计，架构原型实现及核心模块的开发工作；</p>
                            <p>2、参与系统需求分析与设计，并负责完成PHP核心代码，以及接口规范的制定；</p>
                            <p>3、完成相关的技术文档的编写。</p>
                        </div>
                        <div class="infortext">
                            <div class="texts">任职要求：</div>
                            <p>1、本科以上学历，3年以上相关工作经验，具备良好的编程习惯和学习能力；</p>
                            <p>2、熟练掌握PHP、Mysql，以及常用数据结构和算法；</p>
                            <p>3、具备良好的分析设计能力，WEB常见问题的解决模式；</p>
                            <p>4、熟悉Linux系统，熟悉shell编程；</p>
                            <p>5、优先条件：熟悉 unix 下C/C++ 开发。</p>
                        </div>
                    </div>
                    <div class="infors">
                        <div class="abclose"></div>
                        <div class="infortitle">WEB服务端工程师</div>
                        <div class="infortext">
                            <div class="texts">任职要求：</div>
                            <p>1、良好的编程习惯，良好的学习能力，基础知识扎实；</p>
                            <p>2、熟练掌握PHP、Mysql；</p>
                            <p>3、熟练掌握常用数据结构和算法；</p>
                            <p>4、具备良好的分析设计能力，WEB常见问题的解决模式；</p>
                            <p>5、熟悉Linux系统，熟悉shell编程；</p>
                            <p>6、优先条件：熟悉 unix 下C/C++ 开发。</p>
                        </div>
                    </div>
                    <div class="infors">
                        <div class="abclose"></div>
                        <div class="infortitle">广告销售经理</div>
                        <div class="infortext">
                            <div class="texts">职位描述：</div>
                            <p>1、负责无线互联网的广告接洽、商务洽谈，协助上级完善公司产品销售渠道，对市场需求进行分析、销售预测，制定销售计划和指标；</p>
                            <p>2、与客户进行良好的联络沟通，开展商务洽谈等新客户开发和业务开拓工作，签订订单，回收相关服务款项；</p>
                            <p>3、拓展及维护新老商户,完成企业产品销售目标；</p>
                            <p>4、熟悉公司理念及产品，了解客户需求，能够为客户提出个性化的解决方案，通过多种推广方式，达成广告推广合作，完成各项业绩指标。</p>
                        </div>
                        <div class="infortext">
                            <div class="texts">任职要求：</div>
                            <p>1、2年以上品牌广告销售经验（互联网、移动互联网媒体销售）或2-3年广告代理公司服务、开拓经验；</p>
                            <p>2、熟悉4A、媒介公司广告投放流程，有优质的广告资源和客户资源；</p>
                            <p>3、熟悉无线互联网行业，有相关客户资源者优先；</p>
                            <p>4、有快消、日用品、家电、汽车、电商、母婴方向客户资源者优先。</p>
                        </div>
                    </div>
                    <div class="infors">
                        <div class="abclose"></div>
                        <div class="infortitle">APP推广专员</div>
                        <div class="infortext">
                            <div class="texts">职位描述：</div>
                            <p>1、负责公司APP产品的推广工作，并配合部门负责人完成其他商务推广工作；</p>
                            <p>2、负责在和应用市场的版本更新上架以及评论、排名优化工作；</p>
                            <p>3、了解并实操过主流安卓应用商店的首发、换量、特权等活动；</p>
                            <p>4、负责推广渠道的数据监控和反馈跟踪，对数据进行综合分析，及时调整推广策略。</p>
                        </div>
                        <div class="infortext">
                            <div class="texts">任职要求：</div>
                            <p>1、本科以上学历，具备良好的职业素质；</p>
                            <p>2、熟悉各大软件下载平台、appstore、安卓应用市场的APP推广方式，并配合部门负责人完成其他商务推广工作；</p>
                            <p>3、熟悉iOS和Android平台及App产品，对App的推广和运营有自己的认识；</p>
                            <p>4、具备良好的理解、表达和沟通的能力，以及较强的逻辑思维、调研及分析能力；</p>
                            <p>5、有一定的抗压能力，较强的团队合作意识。</p>
                        </div>
                    </div>
                    <div class="infors">
                        <div class="abclose"></div>
                        <div class="infortitle">运营专员</div>
                        <div class="infortext">
                            <div class="texts">职位描述：</div>
                            <p>1、学习公司业务体系，负责公司订单运营中心的处理、跟踪与反馈；</p>
                            <p>2、负责监控异常订单及相关审核工作；</p>
                            <p>3、负责异常订单的处理及协调。</p>
                        </div>
                        <div class="infortext">
                            <div class="texts">任职要求：</div>
                            <p>1、专科及以上学历；</p>
                            <p>2、熟练使用计算机及办公软件；</p>
                            <p>3、具有沟通能力、协调能力，工作认真仔细；</p>
                            <p>4、团队意识强，善于沟通，有热情。</p>
                        </div>
                    </div>
                    <div class="infors">
                        <div class="abclose"></div>
                        <div class="infortitle">客服专员</div>
                        <div class="infortext">
                            <div class="texts">职位描述：</div>
                            <p>1、学习公司业务体系，为客户提供专业的服务，对于客户遇到的问题给出专业的回复；</p>
                            <p>2、独立推进完成自己遇到的问题；</p>
                            <p>3、回访已完成服务的用户，确认满意度；</p>
                            <p>4、维护老客户，提高复购率。</p>
                        </div>
                        <div class="infortext">
                            <div class="texts">任职要求：</div>
                            <p>1、20-26岁，大专以及本科以上学历，热爱客服岗位；</p>
                            <p>2、有丰富的客服和电话销售经验优先，勤奋敬业、责任心强，思路清晰；</p>
                            <p>3、普通话标准，懂得消费者心理，语言表达能力强，擅于沟通，有团队合作精神；</p>
                            <p>4、电脑使用熟练，打字速度每分钟60字以上，熟悉办公软件。</p>
                        </div>
                    </div>
                    <div class="infors">
                        <div class="abclose"></div>
                        <div class="infortitle">招商客户专员</div>
                        <div class="infortext">
                            <div class="texts">职位描述：</div>
                            <p>1、根据市场部经理安排的任务和工作要求制订详细的工作计划并执行；</p>
                            <p>2、负责客户前期的电话沟通、知识讲解、初步洽谈，维护好与客户之间的良好关系，进行邀约；</p>
                            <p>3、促进公司与客户的合作实地考察的接待安排、协助经理进行招商谈判；</p>
                            <p>4、在和客户签约后，负责客户入驻的各项手续的沟通跟进；&nbsp;</p>
                            <p>5、完成领导交待的其他工作。</p>
                        </div>
                        <div class="infortext">
                            <div class="texts">任职要求：</div>
                            <p>1、本科及以上学历，1年以上招商、销售类工作经验，优秀应届生亦可；</p>
                            <p>2、熟悉招商流程、招商技巧、合同条款以及市场操作模式；</p>
                            <p>3、有出色的客户服务意识、较强的业务拓展和人际交往沟通能力；</p>
                            <p>4、诚实守信、勤奋敬业。</p>
                        </div>
                    </div>
                    <div class="infors">
                        <div class="abclose"></div>
                        <div class="infortitle">客户中心专员</div>
                        <div class="infortext">
                            <div class="texts">职位描述：</div>
                            <p>1、处理用户（个人和企业）发起的服务需求（如长期保洁服务、做饭服务等），及时跟进用户，协调服务团队共同完成签约；</p>
                            <p>2、根据签约用户的需求，协调服务团队为用户进行服务；</p>
                            <p>3、定期回访用户，了解用户体验，及时处理用户反馈，以改进服务体验；</p>
                            <p>4、遵从公司相关制度和标准流程，达成每日业绩指标KPI，完成设定的各种目标。&nbsp;</p>
                        </div>
                        <div class="infortext">
                            <div class="texts">任职要求：</div>
                            <p>1、本科以上学历，具备良好的职业素质；</p>
                            <p>2、具备2年左右销售及客户服务经验，有良好的销售能力和客户维护能力；</p>
                            <p>3、良好的沟通能力、抗压力，愿意接受挑战。</p>
                        </div>
                    </div>
                    <div class="infors">
                        <div class="abclose"></div>
                        <div class="infortitle">客户中心主管/经理</div>
                        <div class="infortext">
                            <div class="texts">职位描述：</div>
                            <p>1、管理客户中心团队，执行并监督客户中心团队KPI的完成； </p>
                            <p>2、培训客户中心团队，不断提升客户中心团队的服务意识和服务能力；</p>
                            <p>3、客户中心团队的主要工作是处理用户（个人和企业）发起的服务需求（如长期保洁服务、做饭服务等），及时跟进用户，协调服务团队共同完成签约，并根据签约用户的需求，协调服务团队为用户进行服务以及后续维护管理；</p>
                            <p>4、遵从公司相关制度和标准流程，达成每日业绩指标KPI，完成设定的各种目标。&nbsp;</p>
                        </div>
                        <div class="infortext">
                            <div class="texts">任职要求：</div>
                            <p>1、本科以上学历，具备良好的职业素质；</p>
                            <p>2、具备3年以上销售及客户服务经验，1年以上5-10人团队管理经验；</p>
                            <p>3、良好的沟通能力、抗压力，愿意接受挑战；</p>
                            <p>4、具备良好的销售培训能力和客户维护能力。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>