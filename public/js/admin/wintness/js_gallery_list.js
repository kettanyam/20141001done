'use strict';

/*
 * sort table object
 */
var sortTable = function(o){
    // initialize
    o.init = function(){
        var self = this;
        self.trs = [];
        self.updateId = null;
        self.$el = $(self.el);

        self.$el.tableDnD({
            onDragClass: 'onDraging',
            onDragStart: function(table, row){
                if (self.updateId!=null)
                    self.resetStatus();
            },
            onDrop: function(table, row){
                self.resetTrCollection();
                self.updateSort(row.id);
            }
        });

        self.ajaxSortURL = self.$el.attr('data-sortAction');
        self.resetTrCollection();
        return self;
    }

    /*
     * get specific row by id
     * @params (int) id,
     * @params (object) model
     */
    o.getTr = function(id){
        var i = 0,
            len = this.trs.length,
            index;
        for(; i<len; i++){
            if (id==this.trs[i].id){
                index = i;
                break;
            }
        }
        return {index: index, tr: this.trs[index]};
    }

    /*
     * get html by specific tr object
     * @params (object) tr
     * @params (int) index
     * @return (mixed) value
     */
    o.getTd = function(tr, tdIndex){
        if (typeof(tr)=='undefined' || typeof(tdIndex)=='undefined')
            return false;
        return tr.$el.find('td:nth-child('+tdIndex+')').html();
    }


    /*
     * reset tr collection
     */
    o.resetTrCollection = function(){
        var self = this,
            tr;
        while(tr=self.trs.pop()){
            tr.$el.find('.btn-modify').unbind();
        }

        self.$el.find('tbody tr').each(function(idx, tr){
            var $el = $(this);

            self.trs.push({
                id: tr.id,
                $el: $el
            });
        });
    }

    /*
     * reset status
     */
    o.resetStatus = function(){
        if (this.updateId!=null){
            var r = this.getTr(this.updateId);
            r.tr.$el.removeClass('onDraging');
            formCategory.reset();
        }
        this.updateId==null;
    }

    /*
     * update specific row by model
     * @params (object) model, {key, data}
     */
    o.updateRow = function(model){
        if (typeof(model)=='undefined')
            alert('提醒您:\n\n    系統更新錯誤 [10]');
        var r = this.getTr(model.id);
        r.tr.$el.find('td').each(function(idx, td){
            if (idx==0)
                td.innerHTML = model.title;
            if (idx==1)
                td.innerHTML = parseInt(model.sort);
        });
        this.resetStatus();
    }

    /*
     * update sort
     * @params (int) updatedId
     */
    o.updateSort = function(updatedId){
        var self = this,
            len = this.trs.length,
            r = this.getTr(updatedId),
            params = {id: updatedId};

        if (len==1)
            return;

        if (r.index==0){
            var sort = this.getTd(this.trs[1], self.sortColumn);
            params.sort = parseInt(sort) + 2 ;
        }else if(r.index==(len-1)){
            var idx = r.index-1,
                sort = this.getTd(this.trs[idx], self.sortColumn);
            params.sort = parseInt(sort) - 1;
            if (params.sort<=0){
                params.sort = 1;
                params.isUpdatedTime = true;
                params.lastUpdatedId = this.trs[idx].id;
            }
        }else{
            var beforeSort = parseInt(this.getTd(this.trs[r.index-1], self.sortColumn)),
                afterSort = parseInt(this.getTd(this.trs[r.index+1], self.sortColumn));

            if (beforeSort==afterSort){
                params.sort = beforeSort;
                params.isUpdatedTime = true;
                params.lastUpdatedId = this.trs[r.index-1].id;
            }else{
                if ((beforeSort-afterSort)==2)
                    params.sort = Math.round((beforeSort+afterSort)/2);
                else{
                    params.sort = beforeSort;
                    params.isUpdatedTime = true;
                    params.lastUpdatedId = this.trs[r.index-1].id;
                }
            }
        }

        $.ajax({
            url: self.ajaxSortURL,
            type: 'POST',
            data: params,
            dataType: 'json',
            success: function(res, s, xhr){
                alert(res.message);
                if (res.status=='ok')
                    r.tr.$el.find('td:nth-child('+self.sortColumn+')').html(params.sort);
                return;
            },
            error: function(){
                alert("系統更新錯誤，請通知工程師 [11]");
                return;
            }
        });
    }

    return o.init();

}({el: '#sortable', sortColumn: 5});

$(function(){
    $('.btn-delete').on('click', function(e){
        return (confirm("提醒您:\n\n\t確定要刪除該圖片資料嗎?"));
    });
});