window.App = Ember.Application.create();

App.Router.map(function() {
    this.route("index", {path: "/"});
    this.route("info", {path: "/info"});
    this.resource("bands", {path: "/bands"}, function() {
        this.route("korpus", {path: "korpus"});
        this.route("arroganz", {path: "arroganz"});
        this.route("rogash", {path: "rogash"});
        this.route("origin-of-zed", {path: "origin-of-zed"});
        this.route("metabolic", {path: "metabolic"});
    });
    this.route("bands/korpus", {path: "/bands/korpus"});
    this.route("reservierung", {path: "/reservierung"});
    this.route("kontakt", {path: "/kontakt"});
});

//App.IndexRoute = Ember.Route.extend({
//    beforeModel: function() {
//        this.transitionTo('info');
//    }
//});
