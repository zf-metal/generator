(function ($) { //an IIFE so safely alias jQuery to $
    $.MetalPlugin = function (element) { //renamed arg for readability
        this.element = (element instanceof $) ? element : $(element);
    };
    $.MetalPlugin.prototype = {
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
            this.pluginAction();
        },
        pluginAction: function () {
            var that = this;
            $.get("/generator/module/plugin/main/" + this.moduleId).done(function (data) {
                $("#pluginContent").html(data);
                that.buttonInit();
            });
        },
        generatorAction: function (pluginId, pluginName) {
            this.modal.title("Generating Plugin: " + pluginName);
            this.modal.loading();
            this.modal.toggle();
            var that = this;
            $.get("/generator/module/plugin/generator/" + pluginId).done(function (data) {
                that.modal.box(data);
            });
        },
        generatorAllAction: function (event) {
            var self = event.data.self;
            self.modal.title("Generating Plugin: ");
            self.modal.loading();
            self.modal.toggle();
            var that = self;
            $.get("/generator/module/plugin-all/generator/" + self.moduleId).done(function (data) {
                that.modal.box(data);
            });
        },
        buttonInit: function () {
            $('#btn-generate-plugin').on('click', {self: this}, this.generatorAllAction);
        }
    };
}(jQuery));
