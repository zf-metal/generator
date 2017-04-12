(function ($) { //an IIFE so safely alias jQuery to $
    $.MetalViewHelper = function (element) { //renamed arg for readability
        this.element = (element instanceof $) ? element : $(element);
    };
    $.MetalViewHelper.prototype = {
        loading: "Loading...",
        moduleId: null,
        modal: null,
        setModal: function (modal) {
            if (typeof modal === 'object' && modal.theclass === "MetalModal") {
                this.modal = modal;
            } else {
                console.log(modal);
                alert("modal must be MetalModal");
            }
        },
        run: function (moduleId) {
            this.moduleId = moduleId;
            this.viewHelperAction();
        },
        viewHelperAction: function () {
            var that = this;
            $.get("/generator/module/view-helper/main/" + this.moduleId).done(function (data) {
                $("#viewHelperContent").html(data);
                that.buttonInit();
            });
        },
        generatorAction: function (viewHelperId, viewHelperName) {
            this.modal.title("Generating ViewHelper: " + viewHelperName);
            this.modal.loading();
            this.modal.toggle();
            var that = this;
            $.get("/generator/module/view-helper/generator/" + viewHelperId).done(function (data) {
                that.modal.box(data);
            });
        },
        generatorAllAction: function (event) {
            var self = event.data.self;
            self.modal.title("Generating ViewHelper: ");
            self.modal.loading();
            self.modal.toggle();
            var that = self;
            $.get("/generator/module/view-helper-all/generator/" + self.moduleId).done(function (data) {
                that.modal.box(data);
            });
        },
        buttonInit: function () {
            $('#btn-generate-view-helper').on('click', {self: this}, this.generatorAllAction);
        }
    };
}(jQuery));
