/**
 *  @package wp-backbone
 *  @author  Md Imranur Rahman <imran.aspire@gmail.com>
 *
 *  main  run  file
 **/

App = this.App || {};


window.App = App;

App.domain = WBF_globals.domain;
App.isLogin = WBF_globals.isLogin;
App.imageUrl = WBF_globals.imageurl;


var $ = jQuery.noConflict();

App.run = function() {

    $(document).on('ready', function(){

        var templateUrl = WBF_globals.jsurl + "/post/templates/";

        // get templates
        App.template = function(url) {
            var data = "<h1> failed to load url : " + url + "</h1>";
            $.ajax({
                async: false,
                url: templateUrl + url + ".html",
                success: function(response) {
                    data = response;
                }
            });
            return data;
        }

        // load required script
        function require(script) {
            $.ajax({
                url: script,
                dataType: "script",
                async: false,
                success: function () {},
                error: function () {
                    throw new Error("Could not load script " + script);
                }
            });


        }

        // loading  backbone  Post script
        var scripts = ["models", "collections", "views", "router"];
        for(var i=0; i< scripts.length; i++){
            require(WBF_globals.jsurl + "/post/" +scripts[i] + ".js");
        }

        App.postRouter = new App.PostRouter();
        Backbone.history.start();

    });


};

App.run();
