(function ($) { //an IIFE so safely alias jQuery to $
    $.MetalEntities = function (element) { //renamed arg for readability
        this.element = (element instanceof $) ? element : $(element);
    };
    $.MetalEntities.prototype = {
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
            this.entitiesAction();
        },
        entitiesAction: function () {
            $.get("/generator/module/entity/main/" + this.moduleId).done(function (data) {
                $("#entityTab").html(data);
            });
        },
        propertiesAction: function (entityId, entityName) {

            this.modal.title("Edit entity properties : " + entityName);
            this.modal.loading();
            this.modal.toggle();
            var that = this;
            $.get("/generator/module/entity/property/" + entityId).done(function (data) {
                that.modal.box(data);
            });
        },

        generatorAction: function (entityId, entityName) {
            this.modal.title("Generating Entity : " + entityName);
            this.modal.loading();
            this.modal.toggle();
            var that = this;
            $.get("/generator/module/entity/generator/" + entityId).done(function (data) {
                that.modal.box(data);
            });
        }

    };
}(jQuery));
