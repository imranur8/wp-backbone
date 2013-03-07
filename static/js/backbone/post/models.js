/**
 *  @package wp-backbone
 *  @author  Md Imranur Rahman <imran.aspire@gmail.com>
 *
 *  define post models
 **/

App.Post = Backbone.Model.extend({

    defaults: {
        id: null,
        title: null,
        content: null,
        post_name: null,
        post_excerpt: null,
        status: "Update"
    },

    sync: function(method, model, options){

        var url = App.domain + "/api/mypost";
        var currentModel = model;

        if(method == 'create'){
            method = 'POST';
            console.log("Creating a  Post");
            data = {
                method: "create",
                title: currentModel.get("title"),
                content: currentModel.get("content"),
                excerpt: currentModel.get("post_excerpt")
            };

            var req = $.ajax({
                url: url,
                type: method,
                data: data,
                dataType: 'json'
            });

            req.done(function(response){
                currentModel.set("id", response.id);
                currentModel.set("post_name", response.post_name);
                currentModel.set("status", "Update");
                options.success(response);
            })

        }
        if(method == 'update'){

            console.log("Updating a  Post");
            method = 'POST';

            data = {
                method: "update",
                title: currentModel.get("title"),
                content: currentModel.get("content"),
                excerpt: currentModel.get("post_excerpt"),
                id: currentModel.get("id")

            };

            var req = $.ajax({
                url: url,
                type: method,
                data: data,
                dataType: 'json',
                beforeSend: function(xhr){
                    xhr.setRequestHeader("Content-Type", 'application/x-www-form-urlencoded');
                }
            });

            req.done(function(response){
                options.success(response);
            })

        }

        if(method == 'delete'){

            console.log("Deleteing a  Post");
            method = "DELETE";

            var req = $.ajax({
                url: url + "/" + model.get('id'),
                type: method,
                dataType: 'json',
                beforeSend: function(xhr){
                }
            });

            req.done(function(response){
                options.success(response);
            });

            req.error(function(xhr, ajaxOptions, thrownError) {
                options.error(xhr.status);
            });
        }

        if(method == 'get'){

            console.log("GET a Post");
            method = "GET";

            data = {
                post_name: currentModel.get("post_name")
            };

            var req = $.ajax({
                url: url ,
                type: method,
                data: data,
                dataType: 'json'
            });

            req.done(function(response){
                currentModel.set("id", response.ID);
                currentModel.set("title", response.post_title);
                currentModel.set("content", response.post_content);
                currentModel.set("post_excerpt", response.post_excerpt);
                currentModel.save();

                options.success(response);
            });

            req.error(function(xhr, ajaxOptions, thrownError) {
                options.error(xhr.status);
            });
        }

    }
});