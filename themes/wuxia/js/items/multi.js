/**
 * Created with JetBrains PhpStorm.
 * User: luckymancvp
 * Date: 9/27/12
 * Time: 2:08 PM
 * To change this template use File | Settings | File Templates.
 */

$(document).ready(function(){

    /**
     * Data table
     */
    $('.datatable').dataTable( {
        "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
            "sLengthMenu": "_MENU_ records per page"
        }
    });
    $('.datatable-controls').on('click','li input',function(){
        dtShowHideCol( $(this).val() );
    })

    /**
     * Backbone
     */
    var Item  = Backbone.Model.extend({
    });

    var Items = Backbone.Collection.extend({
        model : Item
    });

    var ItemView = Backbone.View.extend({
        template: $("#blankItem").html(),
        initialize: function(){
        },
        events: {
        },
        render: function(){
            var tmpl = _.template(this.template);
            this.$el.html(tmpl(this.model.toJSON()));
            return this;
        }
    });

    MasterView = Backbone.View.extend({
        el: "#table-items tbody",
        tableEl: $("#table-items"),
        initialize: function(){
            this.collection = new Items([{}, {}]);

            //Add event listener
            this.collection.on("add", this.renderItem, this);


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
            var itemChildren = itemView.render().$el.find("td");
            var tdArray = new Array();
            for ( var i=0; i<itemChildren.length; i++){
                tdArray[i] = $(itemChildren[i]).html();
            }
            this.tableEl.dataTable().fnAddData(tdArray);
        },
        addBlank: function(count){
            for (i=0; i<count; i++){
                blankItem = new Item({});
                this.collection.add(blankItem);
            }
            return false;
        }

    });
    masterView = new MasterView();
});