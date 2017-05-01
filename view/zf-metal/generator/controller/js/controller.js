(function ($) { //an IIFE so safely alias jQuery to $
    $.MetalControllers = function (element) { //renamed arg for readability
        this.element = (element instanceof $) ? element : $(element);
    };
    $.MetalControllers.prototype = {
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
            this.controllerAction();
        },
        controllerAction: function () {
            $.get("/generator/module/controller/main/" + this.moduleId).done(function (data) {
                $("#controllerTab").html(data);
            });
        },
        actionsAction: function (controllerId, controllerName) {
              var btn = $('<a class="btn btn-danger btn-xs glyphicon glyphicon-play" onclick="MetalControllers.generatorAction(' + controllerId + ',\''+controllerName+'\')"></a>');
          
            this.modal.title("Edit actions Controller: " + controllerName + " ");
             this.modal.modalTitle.append(btn);
            this.modal.loading();
            this.modal.toggle();
            var that = this;
            $.get("/generator/module/action/controller/" + controllerId).done(function (data) {
                that.modal.box(data);
            });
        },
        generatorAction: function (controllerId, controllerName) {
           this.modal.title("Generating Controller: " + controllerName);
            this.modal.loading();
            this.modal.modal.modal("show");
            var that = this;
            $.get("/generator/module/controller/generator/" + controllerId).done(function (data) {
                that.modal.box(data);
            });
        }

    };
}(jQuery));
