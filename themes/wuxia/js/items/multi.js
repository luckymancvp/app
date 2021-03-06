/**
 * Created with JetBrains PhpStorm.
 * User: luckymancvp
 * Date: 9/27/12
 * Time: 2:08 PM
 * To change this template use File | Settings | File Templates.
 */

$(document).ready(function(){

    /**
     * Backbone
     */
    var Item  = Backbone.Model.extend({
    });

    var Items = Backbone.Collection.extend({
        model : Item
    });

    var ItemView = Backbone.View.extend({
        tagName: "tr",
        template: $("#blankItem").html(),
        initialize: function(){
        },
        events: {
            "click .trans"     : "trans",
            "click .del"       : "del",
            "click .save"       : "save"
        },
        render: function(){
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
            this.model.destroy();
            that = this;
            this.$el.fadeOut("slow",function(){
                that.remove();
            });


        },
        save: function(){
            wordEl     = this.$el.find("#Items_word");
            meaningdEl = this.$el.find("#Items_meaning");
            that = this;
            $.ajax({
                url: addUrl,
                type: "POST",
                context: that,
                data:{
                    "Items[word]"    : wordEl.val(),
                    "Items[meaning]" : meaningdEl.val(),
                    "Items[set_id]" : $("#Items_set_id").val()
                },
                beforeSend: function(){
                    this.loading();
                },
                success: function(res){
                    if (res == "1"){
                        this.$el.find(".save").html("Saved");
                        this.$el.find(".save").attr("disabled","disabled");
                    }
                },
                complete: function(res){
                    this.loadComplete();
                }
            });
        }
    });

    MasterView = Backbone.View.extend({
        el: "#table-items tbody",
        tableEl: $("#table-items"),
        initialize: function(){
            this.collection = new Items([{}, {}]);

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