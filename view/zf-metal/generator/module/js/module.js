(function ($) { //an IIFE so safely alias jQuery to $
    $.MetalModule = function (element) { //renamed arg for readability
        this.element = (element instanceof $) ? element : $(element);
    };
    $.MetalModule.prototype = {

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
            this.btnInit();
        },
        btnInit: function () {
            $('#btn-generate-module').on('click', {self: this}, this.generatorModuleAction);
            $('#btn-generate-module-config').on('click', {self: this}, this.generatorModuleConfigAction);

        },
        generatorModuleAction: function (event) {
            var self = event.data.self;
            self.modal.title("Generating Module: ");
            self.modal.loading();
            self.modal.toggle();

            $.get("/generator/module/generator/" + self.moduleId).done(function (data) {
              self.modal.box(data);
            });
        },
         generatorModuleConfigAction: function (event) {
            var self = event.data.self;
            self.modal.title("Generating Module: ");
            self.modal.loading();
            self.modal.toggle();

            $.get("/generator/module/generator/config/" + self.moduleId).done(function (data) {
             self.modal.box(data);
            });
        }

    };
}(jQuery));
