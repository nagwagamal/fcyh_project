var editableContent = function () {
    return {
        init: function () {
            var editor = new MediumEditor(".editable", {
                buttonLabels: "fontawesome"
            });
        }
    };
}();

$(function () {
	"use strict";
    editableContent.init();
});
