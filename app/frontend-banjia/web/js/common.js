$(function() {
    //validator拓展验证规则
    if(jQuery.validator) {
        //邮政编码验证
        jQuery.validator.addMethod("isZipCode", function(value, element) {
            var zipcode = /^[0-9]{6}$/;
            return this.optional(element) || (zipcode.test(value));
        }, "请填写正确的邮政编码");

        //电话号码
        jQuery.validator.addMethod("isPhone", function(value, element) {
            var phone = /^[1][3578][0-9]{9}$/;
            return this.optional(element) || (phone.test(value));
        }, "请填写正确的手机号码");

        //验证域名
        jQuery.validator.addMethod("isDomain", function(value, element) {
            var domain = /^(?=^.{3,255}$)[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(\.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})+$/;
            return this.optional(element) || (domain.test(value));
        }, "请填写正确的域名");
    }
});

$(window).scroll(function () {
    var headTop = $(document).scrollTop();
    //新滑动模式
    if (headTop < 34) {//正常滑动
    	
    } else {//head top正常滑动，head bottom吸顶，head与bottom等高
    	
    }
    
    if (headTop > 10) {
        $('.header').stop().animate({
            height: '80px'
        }, 100);
        $('.header .head-top').stop().animate({
            top: '-34px'
        }, 20);
        $('.header .head-bottom').stop().animate({
            top: '0px'
        }, 20);
        $('.nav-bg').css('top', '80px');
    } else {
        $('.header').stop().animate({
            height: '114px'
        }, 100);
        $('.header .head-top').stop().animate({
            top: '0px'
        }, 10);
        $('.header .head-bottom').stop().animate({
            top: '34px'
        }, 10);
        $('.nav-bg').css('top', '114px');
    }
});

$(function () {
    //顶部导航效果
    $('.head-list .drop').hover(function() {
        $(this).addClass('hover');
    }, function() {
        $(this).removeClass('hover');
    });

    //主菜单效果
    var subid = null;//nva title状态记录器
    var contentid = null;//nav sub状态记录器
    $('.nav .have-sub').hover(function () {
        $(this).addClass('hover');
        $('.nav-bg').addClass('hover');
        subid = $(this).data('subid');
        $('.nav-bg .header-nav-hide').hide();
        $('#'+'sub-'+subid).show();
    }, function() {
        //延时检测重置状态
        var tVar = setTimeout(function() {
            subid = null;
            if(contentid == null) {
                $('.nav .have-sub').removeClass('hover');
                $('.nav-bg .header-nav-hide').hide();
                $('.nav-bg').removeClass('hover');
                contentid = null;
                subid = null;
            }
        }, 20);
        //clearTimeout(tVar);
    });

    $('.nav-bg').hover(function () {
        contentid = subid;
    }, function() {
        //延时检测重置状态
        var tVar = setTimeout(function() {
            contentid = null;
            if(subid == null) {
                $('.nav .have-sub').removeClass('hover');
                $('.nav-bg .header-nav-hide').hide();
                $('.nav-bg').removeClass('hover');
                contentid = null;
                subid = null;
            }
        }, 20);
        //clearTimeout(tVar);
    });

    //所有侧边pin栏
    /*
    $(".pinned").pin({
        containerSelector: ".sidebox"
    });
    */
    //alert($('html').attr('class'));
});

//返回顶部效果
/*
$(window).scroll(function() {//当屏幕滚动，触生 scroll 事件
    var top1 = $(this).scrollTop();//获取相对滚动条顶部的偏移
    if (top1 > 100) {//当偏移大于200px时让图标淡入（css设置为隐藏）
        $(".back-top").stop().fadeIn();
    }else{
        //当偏移小于200px时让图标淡出
        $(".back-top").stop().fadeOut();
    }
});
*/

/*
$(function () {
    $('.nav li').hover(function () {
        var dataNum = $(this).data('nav');
        if (dataNum != undefined) {
            $(this).find('a').css('color', '#ef880c');
            $(this).find('.navIcon').attr('src', '/assets/2017pc/img/head/nav_hover.png');
            $(this).siblings().find('a').removeAttr('style');
            $(this).siblings().find('.navIcon').attr('src', '/assets/2017pc/img/head/nav.png');
            $('.navHover').show(0, function () {
                $(this).find('ul').eq(dataNum).show().siblings().hide();
            })
            $('.navHover,.headNav').mouseleave(function () {
                $('.navHover').hide(0, function () {
                    $('.navHover').find('ul').hide();
                    $('.nav li a').removeAttr('style');
                    $('.nav li a .navIcon').attr('src', '/assets/2017pc/img/head/nav.png');
                })
            })
            $('.navCode').hover(function () {
                $('.navHover').hide(0, function () {
                    $('.navHover').find('ul').hide();
                    $('.nav li a').removeAttr('style');
                    $('.nav li a .navIcon').attr('src', '/assets/2017pc/img/head/nav.png');
                })
            })
        } else {
            $(this).find('a').css('color', '#ef880c');
            $(this).siblings().find('a').removeAttr('style');
            $(this).siblings().find('.navIcon').attr('src', '/assets/2017pc/img/head/nav.png');
            $('.navHover').hide(0, function () {
                $(this).find('ul').hide();
            })
        }
    })
});
*/

window.turen = yii;
var csrfParam = turen.getCsrfParam();
var csrfToken = turen.getCsrfToken();

/*
对应后台，创建以下模块turen.com、turen.cms、turen.ext、turen.shop、turen.sys、turen.tool、turen.user
*/
turen.com = (function($) {
    var pub = {
        //checkbox全选
        checkAll: function(status) {
            $("input[type='checkbox'][name^='checkid'][disabled!='true']").attr('checked', status);
        },
        //状态更新
        updateStatus: function(_this) {
            _this = $(_this);
            var url = _this.data('url');
            var callback = function(res, _this) {
                if(res.state) {
                    _this.text(res.msg);
                } else {
                    //
                }
            };
            commonRemote({
                url: url,
                data: {},
                callback: callback,
                _this: _this
            });
        },
        scrollTop: function(time) {
            $("body, html").animate({scrollTop: 0}, time);
        },
        feedbackCheck: function(_form) {
            //每次都要清理错误
            $(_form).find('p.error').remove();
            var error = '';
            var hasError = false;

            var content = $(_form).find('textarea[name="Feedback[content]"]');
            error = '';
            if(!content.val().length > 0) {
                error = '内容详情必填';
            }
            if(error != '') {
                hasError = true;
                content.parent('.form-group').append('<p class="error"><i class="iconfont jia-close_b"></i>'+error+'</p>');
            }

            var nickname = $(_form).find('input[name="Feedback[nickname]"]');
            error = '';
            if(!nickname.val().length > 0) {
                error = '称呼必填';
            }
            if(error != '') {
                hasError = true;
                nickname.parent('.form-group .col').append('<p class="error"><i class="iconfont jia-close_b"></i>'+error+'</p>');
            }

            var contact = $(_form).find('input[name="Feedback[contact]"]');
            error = '';
            if(!contact.val().length > 0) {
                error = '联系方式必填';
            }
            if(error != '') {
                hasError = true;
                contact.parent('.form-group .col').append('<p class="error"><i class="iconfont jia-close_b"></i>'+error+'</p>');
            }

            var verifyCode = $(_form).find('input[name="Feedback[verifyCode]"]');
            error = '';
            if(!verifyCode.val().length > 0) {
                error = '验证码必填';
            }
            if(error != '') {
                hasError = true;
                verifyCode.parent('.form-group .col').append('<p class="error"><i class="iconfont jia-close_b"></i>'+error+'</p>');
            }

            if(!hasError) {
                var settings = {
                    url: $(_form).attr('action'),
                    type: $(_form).attr('method'),
                    dataType: 'json',
                    data: $(_form).find('input, textarea').serializeArray(),
                    cache: false,
                    _this: $(_form),
                    callback: function(res, _this) {
                        if(res.state) {
                            _this.parent('.feedback-wrap').find('.fk-text').html('<span class="success-text"><i class="iconfont jia-success2"></i>感谢您对我们工作的支持与帮助，提交已成功</span>');
                            _this.find('.form-group.last button').hide();
                        } else {
                            for(var key in res.msg) {
                                //错误数组error
                                if(res.msg[key][0]) {
                                    var value = res.msg[key][0];
                                    if(key == 'content') {
                                        _this.find('textarea[name="Feedback['+key+']"]').parent('.form-group').append('<p class="error"><i class="iconfont jia-close_b"></i>'+value+'</p>');
                                    } else {
                                        _this.find('input[name="Feedback['+key+']"]').parent('.form-group .col').append('<p class="error"><i class="iconfont jia-close_b"></i>'+value+'</p>');
                                    }
                                }
                            }
                        }
                    }
                };
                commonRemote(settings);
            }

            return false;
        }
    };

    // 私有方法
    function commonRemote(settings) {
        var defaultSetting = {
            url: null,
            type: 'POST',
            dataType: 'json',
            data: null,
            cache: false,
            callback: null,
            _this: null
        };
        $.extend(defaultSetting, settings);
        var _this = defaultSetting._this;
        //data[csrfParam] = csrfToken;

        $.ajax({
            url: defaultSetting.url,
            type: defaultSetting.type,
            dataType: defaultSetting.dataType,
            context: defaultSetting._this,
            cache: defaultSetting.cache,
            data: defaultSetting.data,
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $.notify(XMLHttpRequest.responseText, 'error');
            },
            success: function(res) {
                if(defaultSetting.callback) {
                    defaultSetting.callback(res, _this);
                }
            }
        });
    }

    return pub;
})(jQuery);

turen.user = (function($) {
    var pub = {
        //公共方法
        passwordCheck: function(_this) {
            //每次都要清理错误
            $(_this).find('p.error').remove();
            var error = '';
            var hasError = false;

            var currentPassword = $(_this).find('input[name="SafeForm[currentPassword]"]');
            error = '';
            if(!currentPassword.val().length > 5) {
                error = '当前密码不能小于6位';
            }
            if(!currentPassword.val().length > 0) {
                error = '当前密码必填';
            }
            if(error != '') {
                hasError = true;
                currentPassword.parent('.form-group').append('<p class="error"><i class="iconfont jia-close_b"></i>'+error+'</p>');
            }

            var password = $(_this).find('input[name="SafeForm[password]"]');
            error = '';
            if(!password.val().length > 5) {
                error = '新密码不能小于6位';
            }
            if(!password.val().length > 0) {
                error = '新密码必填';
            }
            if(error != '') {
                hasError = true;
                password.parent('.form-group').append('<p class="error"><i class="iconfont jia-close_b"></i>' + error + '</p>');
            }

            var rePassword = $(_this).find('input[name="SafeForm[rePassword]"]');
            error = '';
            if(!rePassword.val().length > 5) {
                error = '确认密码不能小于6位';
            }
            if(!rePassword.val().length > 0) {
                error = '确认密码必填';
            }
            if(rePassword.val() != password.val()) {
                error = '两次输入的密码不一致';
            }
            if(error != '') {
                hasError = true;
                rePassword.parent('.form-group').append('<p class="error"><i class="iconfont jia-close_b"></i>'+error+'</p>');
            }

            if(!hasError) {
                var url = $(_this).attr('action');
                var type = $(_this).attr('method');
                var data = $(_this).find('input').serializeArray();
                var _this = $(_this);
                var callback = function(res, _this) {
                    if(res.state) {
                        layer.closeAll();
                        $.notify(res.msg, 'success');
                    } else {
                        $.notify(res.msg, 'error');
                    }
                };
                commonRemote(url, data, callback, $(_this), type);
            }

            return false;
        },
        phoneCheck: function(_this) {
            var phoneReg = /^[1][3578][0-9]{9}$/;//手机号码规则
            //每次都要清理错误
            $(_this).find('p.error').remove();
            var error = '';
            var hasError = false;

            var currentPassword = $(_this).find('input[name="SafeForm[currentPassword]"]');
            error = '';
            if(!currentPassword.val().length > 5) {
                error = '当前密码不能小于6位';
            }
            if(!currentPassword.val().length > 0) {
                error = '当前密码必填';
            }
            if(error != '') {
                hasError = true;
                currentPassword.parent('.form-group').append('<p class="error"><i class="iconfont jia-close_b"></i>'+error+'</p>');
            }

            var phone = $(_this).find('input[name="SafeForm[phone]"]');
            error = '';
            if(!phoneReg.test(phone.val())) {//格式判断
                error = '新手机号码格式不正确';
            }
            if(!phone.val().length > 0) {
                error = '新手机号码必填';
            }
            if(error != '') {
                hasError = true;
                phone.parent('.form-group').append('<p class="error"><i class="iconfont jia-close_b"></i>' + error + '</p>');
            }

            var phoneCode = $(_this).find('input[name="SafeForm[phoneCode]"]');
            error = '';
            if(!phoneCode.val().length > 0) {
                error = '手机验证码必填';
            }
            if(error != '') {
                hasError = true;
                phoneCode.parent('.form-group').append('<p class="error"><i class="iconfont jia-close_b"></i>'+error+'</p>');
            }

            if(!hasError) {
                var url = $(_this).attr('action');
                var type = $(_this).attr('method');
                var data = $(_this).find('input').serializeArray();
                var _this = $(_this);
                var callback = function(res, _this) {
                    if(res.state) {
                        layer.closeAll();
                        $.notify(res.msg, 'success');
                    } else {
                        $.notify(res.msg, 'error');
                    }
                };
                commonRemote(url, data, callback, $(_this), type);
            }

            return false;
        },
        emailCheck: function(_this) {
            var emailReg = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;//邮箱地址规则
            //每次都要清理错误
            $(_this).find('p.error').remove();
            var error = '';
            var hasError = false;

            var currentPassword = $(_this).find('input[name="SafeForm[currentPassword]"]');
            error = '';
            if(!currentPassword.val().length > 5) {
                error = '当前密码不能小于6位';
            }
            if(!currentPassword.val().length > 0) {
                error = '当前密码必填';
            }
            if(error != '') {
                hasError = true;
                currentPassword.parent('.form-group').append('<p class="error"><i class="iconfont jia-close_b"></i>'+error+'</p>');
            }

            var email = $(_this).find('input[name="SafeForm[email]"]');
            error = '';
            if(!emailReg.test(email.val())) {//格式判断
                error = '新邮箱地址格式不正确';
            }
            if(!email.val().length > 0) {
                error = '新邮箱地址必填';
            }
            if(error != '') {
                hasError = true;
                email.parent('.form-group').append('<p class="error"><i class="iconfont jia-close_b"></i>' + error + '</p>');
            }

            var emailCode = $(_this).find('input[name="SafeForm[emailCode]"]');
            error = '';
            if(!emailCode.val().length > 0) {
                error = '邮箱证码必填';
            }
            if(error != '') {
                hasError = true;
                emailCode.parent('.form-group').append('<p class="error"><i class="iconfont jia-close_b"></i>'+error+'</p>');
            }

            if(!hasError) {
                var url = $(_this).attr('action');
                var type = $(_this).attr('method');
                var data = $(_this).find('input').serializeArray();
                var _this = $(_this);
                var callback = function(res, _this) {
                    if(res.state) {
                        layer.closeAll();
                        $.notify(res.msg, 'success');
                    } else {
                        $.notify(res.msg, 'error');
                    }
                };
                commonRemote(url, data, callback, $(_this), type);
            }

            return false;
        },
        phoneCode: function(_this) {
            //按钮状态不可用
            if(!phoneCodeBtnStatus) {
                return false;
            }

            //初始化
            var _this = $(_this);
            var form = _this.parents('form');
            var phoneReg = /^[1][3578][0-9]{9}$/;//手机号码规则

            //验证码效果
            var count = 99; //间隔函数，1秒执行
            var InterValObj1; //timer变量，控制时间
            var curCount1;//当前剩余秒数

            //每次都要清理错误
            form.find('p.error').remove();
            var error = '';
            var hasError = false;

            var phone = form.find('input[name="SafeForm[phone]"]');
            error = '';
            if(!phoneReg.test(phone.val())) {//格式判断
                error = '新手机号码格式不正确';
            }
            if(!phone.val().length > 0) {
                error = '新手机号码必填';
            }
            if(error != '') {
                hasError = true;
                phone.parent('.form-group').append('<p class="error"><i class="iconfont jia-close_b"></i>' + error + '</p>');
            }

            if(!hasError) {
                //发送验证码效果
                //console.log('发送验证码');
                curCount1 = count;
                //设置button效果，开始计时
                phoneCodeBtnStatus = 0;
                _this.html( + curCount1 + "秒再获取");

                var url = _this.data('url');
                var type = 'GET';
                var data = {phone: phone.val(), signTemplate: 'update_code'};
                var callback = function(res, _this) {
                    if(res.state) {
                        _this.parents('form').find('input[name="SafeForm[phoneCode]"]').focus();
                        $.notify(res.msg, 'success');
                    } else {
                        $.notify(res.msg, 'error');
                        phoneCodeBtnStatus = 1;//启用按钮
                        _this.html("重新发送");
                    }
                };
                commonRemote(url, data, callback, _this, type);

                InterValObj1 = window.setInterval(function() {
                    if (curCount1 == 0) {
                        window.clearInterval(InterValObj1);//停止计时器
                        phoneCodeBtnStatus = 1;//启用按钮
                        _this.html("重新发送");
                    } else {
                        curCount1--;
                        _this.html( + curCount1 + "秒再获取");
                    }
                }, 1000);//启动计时器，1秒执行一次
            }

            return false;
        },
        emailCode: function(_this) {
            //按钮状态不可用
            if(!emailCodeBtnStatus) {
                return false;
            }

            //初始化
            var _this = $(_this);
            var form = _this.parents('form');
            var emailReg = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;//邮箱地址规则

            //验证码效果
            var count = 299; //间隔函数，1秒执行
            var InterValObj1; //timer变量，控制时间
            var curCount1;//当前剩余秒数

            //每次都要清理错误
            form.find('p.error').remove();
            var error = '';
            var hasError = false;

            var email = form.find('input[name="SafeForm[email]"]');
            error = '';
            if(!emailReg.test(email.val())) {//格式判断
                error = '新邮箱地址格式不正确';
            }
            if(!email.val().length > 0) {
                error = '新邮箱地址必填';
            }
            if(error != '') {
                hasError = true;
                email.parent('.form-group').append('<p class="error"><i class="iconfont jia-close_b"></i>' + error + '</p>');
            }

            if(!hasError) {
                //发送验证码效果
                //console.log('发送验证码');
                curCount1 = count;
                //设置button效果，开始计时
                emailCodeBtnStatus = 0;
                _this.html( + curCount1 + "秒再获取");

                var url = _this.data('url');
                var type = 'GET';
                var data = {email: email.val()};
                var callback = function(res, _this) {
                    if(res.state) {
                        _this.parents('form').find('input[name="SafeForm[emailCode]"]').focus();
                        $.notify(res.msg, 'success');
                    } else {
                        $.notify(res.msg, 'error');
                        emailCodeBtnStatus = 1;//启用按钮
                        _this.html("重新发送");
                    }
                };
                commonRemote(url, data, callback, _this, type);

                InterValObj1 = window.setInterval(function() {
                    if (curCount1 == 0) {
                        window.clearInterval(InterValObj1);//停止计时器
                        emailCodeBtnStatus = 1;//启用按钮
                        _this.html("重新发送");
                    } else {
                        curCount1--;
                        _this.html( + curCount1 + "秒再获取");
                    }
                }, 1000);//启动计时器，1秒执行一次
            }

            return false;
        }
    };

    //全局状态控制
    var phoneCodeBtnStatus = 1;//手机验证码发送按钮状态，可用
    var emailCodeBtnStatus = 1;//邮件证码发送按钮状态，可用

    // 私有方法
    function commonRemote(url ,data, callback, _this, type = 'POST') {
        data[csrfParam] = csrfToken;
        $.ajax({
            url: url,
            type: type,
            dataType: 'json',
            context: _this,
            cache: false,
            data: data,
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                //console.log(XMLHttpRequest);
                //console.log(textStatus);
                //console.log(errorThrown);
                $.notify(XMLHttpRequest.responseText, 'error');
            },
            success: function(res) {
                if (res['state']) {
                    if(callback) {
                        callback(res, _this);
                    }
                } else {
                    $.notify(res['msg'], 'warn');
                }
            }
        });
    }

    return pub;
})(jQuery);