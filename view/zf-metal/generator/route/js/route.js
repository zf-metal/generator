(function ($) { //an IIFE so safely alias jQuery to $
    $.MetalRoutes = function (element) { //renamed arg for readability
        this.element = (element instanceof $) ? element : $(element);
    };
    $.MetalRoutes.prototype = {
        tree: null,
        treeDiv: $('<div id="router-treeview"></div>'),
        moduleId: null,
        routeSelected: null,
        routeSelectedId: null,
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
            this.jsonAction();
            this.abmInit();
        },
        jsonAction: function (postLoadSearchName = null) {
            var that = this;
            this.treeDivPush();
            var url = "/generator/module/route/json/" + this.moduleId;
            $.get(url).done(function (data) {
                that.createTreeHelper(data);
                that.search_Init();
                if (postLoadSearchName !== null) {
                    that.searchSubmitHelper(postLoadSearchName);
                }
            });
        },
        createAction: function (event) {
            var self = event.data.self;

            self.modal.title("Create Route");
            self.modal.loading();
            self.modal.toggle();

            var url = "/generator/module/route/create-form/" + self.moduleId;
            if (self.routeSelectedId) {
                url = url + "/" + self.routeSelectedId;
            }

            $.get(url).done(function (data) {
                self.modal.box(data);
            });
        },
        createSubmit: function () {
            var that = this;
            var url = "/generator/module/route/create";
            var postData = $('#Route').serialize();
            var nameSearch = $('#Route').find('[name="name"]').val();
            $.post(
                    url,
                    postData,
                    function (data) {

                        if (typeof data === 'object') {
                            if (data.status === true) {
                                that.clearHelper();
                                that.jsonAction(nameSearch);
                                that.modal.toggle();
                            } else {
                                that.submitErrors(data.errors);
                            }
                        } else {
                            console.log("Server Error");
                        }

                    }
            );
        },
        submitErrors: function (errors) {
            var alertdiv = $('<div id="alertdiv" class="alert alert-danger"></div>');
            $.each(errors, function (key, value) {
                alertdiv.append($('<li>' + value + '</li>'));
            });
            this.modal.alerts(alertdiv);
        },
        editAction: function (event) {
            var self = event.data.self;
            if (self.routeSelectedId) {
                $('#modalLabel').html("Edit Route ");
                self.modal.loading();
                self.modal.toggle();
                var url = "/generator/module/route/edit-form/" + self.routeSelectedId;
                $.get(url).done(function (data) {
                    self.modal.box(data);
                });

            } else {
                alert("Select Route");
                return false;
            }
        },
        editSubmit: function (routeId) {
            var that = this;
            var url = "/generator/module/route/edit/" + routeId;
            var postData = $('#Route').serialize();
            var nameSearch = $('#Route').find('[name="name"]').val();
            $.post(
                    url,
                    postData,
                    function (data) {

                        if (typeof data === 'object') {
                            if (data.status === true) {
                                that.clearHelper();
                                that.jsonAction(nameSearch);
                                that.modal.toggle();
                            } else {
                                that.submitErrors(data.errors);
                            }
                        } else {
                            console.log("Server Error");
                        }

                    }
            );
        },
        deleteAction: function (event) {
            var self = event.data.self;
            if (self.routeSelectedId) {

                var url = "/generator/module/route/delete";
                if (self.routeSelectedId) {
                    url = url + "/" + self.routeSelectedId;
                }

                $.get(url).done(function (data) {
                    self.jsonAction();
                });
            } else {
                alert("Select Route");
                return false;
            }
        },
        generateAction: function (event) {
            var self = event.data.self;

            self.modal.title("Generating routes: ");
            self.modal.loading();
            self.modal.toggle();
            $.get("/generator/module/route/generate/" + self.moduleId).done(function (data) {
                self.modal.box(data);
            });
        },
        clearHelper: function () {
            $('#route-selected-parent_route_name').html("");
            $('#route-selected-route_name').html("");
            $('#route-selected-parent_route_url').html("");
            $('#route-selected-route_url').html("");

            //CLEAR SELECTED
            var nodesSelected = this.tree.treeview('getSelected');
            if (nodesSelected.length) {
                this.tree.treeview('unselectNode', nodesSelected);
            }
            //CLEAR SEARCH
            this.tree.treeview('search', [""]);

            this.routeSelected = null;
            this.routeSelectedId = null;
        },
        clearAction: function (event) {
            var self = event.data.self;
            self.clearHelper();
        },
        collapseAction: function (event) {
            var self = event.data.self;
            self.tree.treeview('collapseAll');
        },
        expandAction: function (event) {
            var self = event.data.self;
            self.tree.treeview('expandAll');
        },
        abmInit: function () {
            $('#btn-add-route').on('click', {self: this}, this.createAction);
            $('#btn-edit-route').on('click', {self: this}, this.editAction);
            $('#btn-del-route').on('click', {self: this}, this.deleteAction);
            $('#btn-clear-route').on('click', {self: this}, this.clearAction);
            $('#btn-clear-collapse').on('click', {self: this}, this.collapseAction);
            $('#btn-clear-expand').on('click', {self: this}, this.expandAction);
            $('#btn-generate-routes').on('click', {self: this}, this.generateAction);
        },
        search_Init: function () {
            $('#btn-search').on('click', {self: this}, this.searchHelper);
            $('#input-search').on('keyup', {self: this}, this.searchHelper);
            $('#btn-clear-search').on('click', {self: this}, function (e) {
                this.Tree.treeview('clearSearch');
                $('#input-search').val('');
            });

            this.tree.on('nodeSelected', {self: this}, this.nodeSelected);
        },
        nodeSelected: function (event, data) {
            var self = event.data.self;
            self.routeSelected = data;
            self.routeSelectedId = data.routeid;
            $('#route-selected-parent_route_url').html(data.parent_route_url);
            $('#route-selected-route_url').html(data.route_url);
            $('#route-selected-parent_route_name').html(data.parent_route_name);
            $('#route-selected-route_name').html(data.route_name);
        },
        searchHelper: function (event) {
            var self = event.data.self;

            var pattern = $('#input-search').val();
            var options = {
                ignoreCase: $('#chk-ignore-case').is(':checked'),
                exactMatch: $('#chk-exact-match').is(':checked'),
                revealResults: $('#chk-reveal-results').is(':checked')
            };
            self.tree.treeview('search', [pattern, options]);
        },
        searchSubmitHelper: function (name) {
            var options = {
                revealResults: true
            };
            this.tree.treeview('search', [name, options]);
        },
        createTreeHelper: function (data) {
            this.tree = this.treeDiv.treeview({
                data: data,
                levels: 1,
                showTags: true,
                color: '#428bca',
                expandIcon: 'glyphicon glyphicon-chevron-right',
                collapseIcon: 'glyphicon glyphicon-chevron-down',
            });
        },
        treeDivPush: function () {
            $("#router-tree-content").html(this.treeDiv);
        }
    };
}(jQuery));
