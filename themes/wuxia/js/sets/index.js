/**
 * Created with JetBrains PhpStorm.
 * User: luckymancvp
 * Date: 9/27/12
 * Time: 2:08 PM
 * To change this template use File | Settings | File Templates.
 */

$(document).ready(function(){

    $("#myModal").hide();
    /**
     * Swap translate language
     */
    window.swapLanguage = function(){
        from = $("#from").val();
        $("#from").val($("#to").val());
        $("#to").val(from);
    };

    /**
     * Backbone
     */
    var Item  = Backbone.Model.extend({
        defaults: {
            word: "",
            meaning : "",
            sound: ""
        }
    });

    var Items = Backbone.Collection.extend({
        model : Item
    });

    var ItemView = Backbone.View.extend({
        tagName      : "tr",
        template     : $("#itemRow").html(),
        blankTemplate: $("#itemBlank").html(),
        initialize   : function(){
        },
        events: {
            "click .trans"     : "trans",
            "click .del"       : "del",
            "click .save"      : "save",
            "click .edit"      : "edit",
            "click .cancel"    : "render"
        },
        render: function(){
            if (this.model.get("id") == null)
                var tmpl = _.template(this.blankTemplate);
            else
                var tmpl = _.template(this.template);
            this.$el.html(tmpl(this.model.toJSON()));
            return this;
        },
        loading: function(){
            this.$el.find("#select-checkbox").hide();
            this.$el.find(".progress").show();
        },
        loadComplete: function(){
            this.$el.find("#select-checkbox").show();
            this.$el.find(".progress").hide();
        },
        trans: function() {
            wordEl    = this.$el.find("#Items_word");
            that = this;
            $.ajax({
                url:translateUrl,
                beforeSend : function(){
                    that.loading();
                },
                context: that,
                data:{
                    text : wordEl.val(),
                    from : $("#from").val(),
                    to   : $("#to").val()
                },
                success: function (res) {
                    meaningEl = this.$el.find("#Items_meaning");
                    meaningEl.val(res);
                },
                complete: function(res){
                    this.loadComplete();
                }
            });
        },
        del: function(){
            that = this;

            if(this.model.get("id") != null){
                $.ajax({
                    url: delItemUrl,
                    data:{
                        item_id: that.model.get("id")
                    },
                    type: 'POST',
                    context: that,
                    success: function(){
                        this.model.clear();
                        this.model.destroy();
                        this.$el.fadeOut("slow",function(){
                            that.remove();
                        });
                    },
                    complete: function(){
                    }
                });
            }
            else{
                this.model.clear();
                this.model.destroy();
                this.$el.fadeOut("slow",function(){
                    that.remove();
                });
            }
        },
        save: function(){
            // get dom element of view
            wordEl     = this.$el.find("#Items_word");
            meaningdEl = this.$el.find("#Items_meaning");
            that = this;

            // Set new value for model
            this.model.set("word", wordEl.val());
            this.model.set("meaning", meaningdEl.val());
            $.ajax({
                url: saveUrl,
                type: "POST",
                context: that,
                data:{
                    "Items[id]"      : that.model.get("id"),
                    "Items[word]"    : wordEl.val(),
                    "Items[meaning]" : meaningdEl.val(),
                    "Items[set_id]"  : $("#Items_set_id").val()
                },
                beforeSend: function(){
                    this.loading();
                },
                success: function(res){
                    if (res > "0"){
                        this.model.set("id",res);
                        this.render();
                    }
                },
                complete: function(res){
                    this.loadComplete();
                }
            });
        },
        edit: function(){
            that = this;
            var tmpl = _.template(this.blankTemplate);
            this.$el.html(tmpl(this.model.toJSON()));
            this.$el.hide().fadeIn("slow",function(){

            });
        }
    });

    MasterView = Backbone.View.extend({
        el: "#table-items tbody",
        tableEl: $("#table-items"),
        initialize: function(){
            this.collection = new Items(itemsJSON);

            //Add event listener
            this.collection.on("add", this.renderItem, this);

            //Add control
            $(".control-a").click(function(){
                switch ($(this).attr("id")){
                    case "trans":
                        $(".trans").click();
                        break;
                    case "del":
                        $(".del").click();
                        break;
                    case "save":
                        $(".save").click();
                        break;
                }
            });

            this.render();
        },
        render: function(){
            var that = this;
            _.each(this.collection.models, function(item){
                that.renderItem(item);
            });
        },
        renderItem: function(item){
            var itemView = new ItemView({model : item});

            itemView.render().$el.appendTo(this.el).hide().fadeIn("slow");
            //this.$el.append();
        },
        addBlank: function(count){
            for (i=0; i<count; i++){
                blankItem = new Item({});
                this.collection.add(blankItem);
            }
            return false;
        },
        transAll: function() {
            console.log("e");
            $(".trans").click();
        }

    });
    masterView = new MasterView();
});