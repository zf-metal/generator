(function ($) { //an IIFE so safely alias jQuery to $
    $.MetalNavigation = function (element) { //renamed arg for readability
        this.element = (element instanceof $) ? element : $(element);
    };
    $.MetalNavigation.prototype = {
        tree: null,
        treeDiv: $('<div id="nav-treeview"></div>'),
        moduleId: null,
        navSelected: null,
        navSelectedId: null,
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
            var url = "/generator/module/nav/json/" + this.moduleId;
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

            self.modal.title("Create Navigation");
            self.modal.loading();
            self.modal.toggle();

            var url = "/generator/module/nav/create-form/" + self.moduleId;
            if (self.navSelectedId) {
                url = url + "/" + self.navSelectedId;
            }

            $.get(url).done(function (data) {
                self.modal.box(data);
            });
        },
        createSubmit: function () {
            var that = this;
            var url = "/generator/module/nav/create";
            var postData = $('#Navigation').serialize();
            var nameSearch = $('#Navigation').find('[name="label"]').val();
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
            if (self.navSelectedId) {
                $('#modalLabel').html("Edit Navigation ");
                self.modal.loading();
                self.modal.toggle();
                var url = "/generator/module/nav/edit-form/" + self.navSelectedId;
                $.get(url).done(function (data) {
                    self.modal.box(data);
                });

            } else {
                alert("Select Navigation");
                return false;
            }
        },
        editSubmit: function (navId) {
            var that = this;
            var url = "/generator/module/nav/edit/" + navId;
            var postData = $('#Navigation').serialize();
            var nameSearch = $('#Navigation').find('[name="label"]').val();
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
            if (self.navSelectedId) {

                var url = "/generator/module/nav/delete";
                if (self.navSelectedId) {
                    url = url + "/" + self.navSelectedId;
                }

                $.get(url).done(function (data) {
                    self.jsonAction();
                });
            } else {
                alert("Select Navigation");
                return false;
            }
        },
        generateAction: function (event) {
            var self = event.data.self;

            self.modal.title("Generating navs: ");
            self.modal.loading();
            self.modal.toggle();
            $.get("/generator/module/nav/generate/" + self.moduleId).done(function (data) {
                self.modal.box(data);
            });
        },
        clearHelper: function () {
            $('#nav-selected-parent_nav_name').html("");
            $('#nav-selected-nav_name').html("");
            $('#nav-selected-parent_nav_url').html("");
            $('#nav-selected-nav_url').html("");

            //CLEAR SELECTED
            var nodesSelected = this.tree.treeview('getSelected');
            if (nodesSelected.length) {
                this.tree.treeview('unselectNode', nodesSelected);
            }
            //CLEAR SEARCH
            this.tree.treeview('search', [""]);

            this.navSelected = null;
            this.navSelectedId = null;
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
            $('#btn-add-nav').on('click', {self: this}, this.createAction);
            $('#btn-edit-nav').on('click', {self: this}, this.editAction);
            $('#btn-del-nav').on('click', {self: this}, this.deleteAction);
            $('#btn-clear-nav').on('click', {self: this}, this.clearAction);
            $('#btn-clear-nav-collapse').on('click', {self: this}, this.collapseAction);
            $('#btn-clear-nav-expand').on('click', {self: this}, this.expandAction);
            $('#btn-generate-navs').on('click', {self: this}, this.generateAction);
        },
        search_Init: function () {
            $('#btn-search-nav').on('click', {self: this}, this.searchHelper);
            $('#input-search-nav').on('keyup', {self: this}, this.searchHelper);
            $('#btn-clear-search-nav').on('click', {self: this}, function (e) {
                this.Tree.treeview('clearSearch');
                $('#input-search-nav').val('');
                $('#search-output-nav').html('');
            });

            this.tree.on('nodeSelected', {self: this}, this.nodeSelected);
        },
        nodeSelected: function (event, data) {
            var self = event.data.self;
            self.navSelected = data;
            self.navSelectedId = data.navid;
            $('#nav-selected-parent_nav_url').html(data.parent_nav_url);
            $('#nav-selected-nav_url').html(data.nav_url);
            $('#nav-selected-parent_nav_name').html(data.parent_nav_name);
            $('#nav-selected-nav_name').html(data.nav_name);
        },
        searchHelper: function (event) {
            var self = event.data.self;

            var pattern = $('#input-search-nav').val();
            var options = {
                ignoreCase: $('#chk-ignore-case-nav').is(':checked'),
                exactMatch: $('#chk-exact-match-nav').is(':checked'),
                revealResults: $('#chk-reveal-results-nav').is(':checked')
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
            $("#nav-tree-content").html(this.treeDiv);
        }
    };
}(jQuery));
