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
            "click .trans"     : "trans"
        },
        render: function(){
            var tmpl = _.template(this.template);
            // generate id
            var date = new Date();
            var components = [
                date.getYear(),
                date.getMonth(),
                date.getDate(),
                date.getHours(),
                date.getMinutes(),
                date.getSeconds(),
                date.getMilliseconds()
            ];

            var id = components.join("");
            this.model.set("id",id);
            this.$el.html(tmpl(this.model.toJSON()));
            return this;
        },
        trans: function() {
            wordEl    = this.$el.find("#Items_word");
            that = this;
            $.ajax({
                url:translateUrl,
                beforeSend : function(){
                    //
                },
                context: that,
                data:{
                    text : wordEl.val(),
                    from : $("#from").val(),
                    to   : $("#to").val()
                }
            }).success(function (res) {
                    meaningEl = this.$el.find("#Items_meaning");
                    meaningEl.val(res);
                    //$("#predefining").hide();
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
            $(".trans-a").click(function(){
                $(".trans").click();
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

            this.$el.append(itemView.render().el);
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