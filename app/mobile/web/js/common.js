$(function () {
    //validator拓展验证规则
    if (jQuery.validator) {
        //邮政编码验证
        jQuery.validator.addMethod("isZipCode", function (value, element) {
            var zipcode = /^[0-9]{6}$/;
            return this.optional(element) || (zipcode.test(value));
        }, "请填写正确的邮政编码");

        //电话号码
        jQuery.validator.addMethod("isPhone", function (value, element) {
            var phone = /^[1][3578][0-9]{9}$/;
            return this.optional(element) || (phone.test(value));
        }, "请填写正确的手机号码");

        //验证域名
        jQuery.validator.addMethod("isDomain", function (value, element) {
            var domain = /^(?=^.{3,255}$)[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(\.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})+$/;
            return this.optional(element) || (domain.test(value));
        }, "请填写正确的域名");
    }
});

