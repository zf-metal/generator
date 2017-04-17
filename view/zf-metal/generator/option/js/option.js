(function ($) { //an IIFE so safely alias jQuery to $
    $.MetalOptions = function (element) { //renamed arg for readability
        this.element = (element instanceof $) ? element : $(element);
    };
    $.MetalOptions.prototype = {
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
            this.optionAction();
        },
        optionAction: function () {
            var that = this;
            $.get("/generator/module/option/main/" + this.moduleId).done(function (data) {
                $("#optionContent").html(data);
                that.buttonInit();
            });
        },
        generatorAction: function (event) {
            var self = event.data.self;
            self.modal.title("Generating Options: ");
            self.modal.loading();
            self.modal.toggle();
            var that = self;
            $.get("/generator/module/option/generator/" + self.moduleId).done(function (data) {
                that.modal.box(data);
            });
        },
        buttonInit: function () {
            $('#btn-generate-option').on('click', {self: this}, this.generatorAction);
        }
    };
}(jQuery));
