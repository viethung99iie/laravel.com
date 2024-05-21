(function ($) {
    ("use strict");
    var HT = {};

    let _token = $('meta[name="csrf-token"]').attr("content");
    HT.switchery = () => {
        $(".js-switch").each(function () {
            var switchery = new Switchery(this, { color: "#1AB394" });
        });
    };

    HT.select2 = () => {
        if ($(".setUpSelect2").length) {
            $(".setUpSelect2").select2();
        }
    };

    HT.changeStatus = () => {
        $(document).on("change", ".status", function () {
            let _this = $(this);
            let option = {
                value: _this.val(),
                model: _this.attr("data-model"),
                modelId: _this.attr("data-modelId"),
                field: _this.attr("data-field"),
                _token: _token,
            };
            console.log(option);
            $.ajax({
                url: "ajax/dashboard/changeStatus",
                type: "post",
                data: option,
                dataType: "json",
                success: function (res) {
                    let inputValue = option.value != 2 ? 2 : 1;
                    if (res.flag) {
                        _this.val(inputValue);
                    }
                },
                error: function (jqXHR, textStatus, errorTh) {
                    console.log("Lỗi " + textStatus + " " + errorTh);
                },
            });
        });
    };
    HT.changeStatusAll = (object) => {
        if ($(".changeStatusAll").length) {
            $(document).on("click", ".changeStatusAll", function (e) {
                let _this = $(this);
                let id = [];
                $(".checkBoxItem").each(function () {
                    let checkBox = $(this);
                    if (checkBox.prop("checked")) {
                        id.push(checkBox.val());
                    }
                });
                let option = {
                    value: _this.attr("data-value"),
                    model: _this.attr("data-model"),
                    field: _this.attr("data-field"),
                    id: id,
                    _token: _token,
                };
                $.ajax({
                    url: "ajax/dashboard/changeStatusAll",
                    type: "post",
                    data: option,
                    dataType: "json",
                    success: function (res) {
                        if (res.flag === true) {
                            let active1 =
                                "background-color: rgb(26, 179, 148);border-color: rgb(26, 179, 148);box-shadow: rgb(26, 179, 148) 0px 0px 0px 16px inset;transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;";
                            let active2 =
                                "left: 20px;transition: background-color 0.4s ease 0s, left 0.2s ease 0s;background-color: rgb(255, 255, 255);";
                            let unactive1 =
                                "box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset;border-color: rgb(223, 223, 223);background-color: rgb(255, 255, 255);transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s;";
                            let unactive2 =
                                "left: 0px;transition: background-color 0.4s ease 0s, left 0.2s ease 0s;";
                            for (let i = 0; i < id.length; i++) {
                                if (option.value == 2) {
                                    $(".js-switch-" + id[i])
                                        .find("span.switchery ")
                                        .attr("style", active1)
                                        .find("small")
                                        .attr("style", active2);
                                } else if (
                                    option.value == 1 ||
                                    option.value == 0
                                ) {
                                    $(".js-switch-" + id[i])
                                        .find("span.switchery ")
                                        .attr("style", unactive1)
                                        .find("small")
                                        .attr("style", unactive2);
                                }
                            }
                        }
                    },
                    error: function (jqXHR, textStatus, errorTh) {
                        console.log("Lỗi " + textStatus + " " + errorTh);
                    },
                });
                e.preventDefault();
            });
        }
    };
    HT.checkALl = () => {
        $(document).on("click", "#checkAll", function (e) {
            let isChecked = $(this).prop("checked");
            $(".checkBoxItem").prop("checked", isChecked);
            $(".checkBoxItem").each(function () {
                let _this = $(this);
                HT.changeBackground(_this);
            });
        });
    };

    HT.checkBoxItem = () => {
        if ($(".checkBoxItem").length) {
            $(document).on("click", ".checkBoxItem", function (e) {
                let _this = $(this);
                HT.changeBackground(_this);
                HT.allChecked();
            });
        }
    };
    HT.sortui = () => {
        $("#sortable").sortable();
        $("#sortable").disableSelection();
    };

    HT.changeBackground = (object) => {
        let isChecked = object.prop("checked");
        if (isChecked) {
            object.closest("tr").addClass("active-bg");
        } else {
            object.closest("tr").removeClass("active-bg");
        }
    };
    HT.allChecked = () => {
        let allChecked =
            $(".checkBoxItem:checked").length === $(".checkBoxItem").length;
        $("#checkAll").prop("checked", allChecked);
    };

    $(document).ready(function () {
        HT.switchery();
        HT.select2();
        HT.changeStatus();
        HT.checkALl();
        HT.checkBoxItem();
        HT.changeStatusAll();
        HT.sortui();
    });
})(jQuery);
