window.App = Ember.Application.create();

App.Router.map(function() {
    this.route("index", {path: "/"});
    this.route("info", {path: "/info"});
    this.route("bands", {path: "/bands"});
    this.route("reservierung", {path: "/reservierung"});
    this.route("kontakt", {path: "/kontakt"});
});

App.IndexRoute = Ember.Route.extend({
    beforeModel: function() {
        this.transitionTo('info');
    }
});
