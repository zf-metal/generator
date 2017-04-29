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
            this.entitiesAction();
        },
        generatorAction: function (entityId, entityName) {
            this.modal.title("Generating Module: ");
            this.modal.loading();
            this.modal.toggle();
            
            $.get("/generator/module/entity/generator/" + entityId).done(function (data) {
                $("#modalContent").html(data);
            });
        }

    };
}(jQuery));
