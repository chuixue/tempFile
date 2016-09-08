/**
 * Created by Administrator on 2016/9/8.
 */

function loadPages(callback){
    $.ajax({url:'http://localhost:86/TempFile/bin/files.php', data: { key: "files", data:"" },
        type: 'get', dataType: "jsonp", Callback: 'callback',
        success: function (_dt) {
            if (_dt.error == 0) {
                callback(_dt.data, _dt.newID);
            }
        },
        error: function (xhr, status, error) {
            console.log("连接服务器失败!");
        }
    });

}

function Paging(_data, _pageSize, _current){
	this.data = data;
	this.pageSize = _pageSize || 10;
	this.current = _current || 1;

    this.prev = function(callback){
        if(this.current > 1)this.getPageData(--this.current, callback);
    };
    this.next = function(callback){
        if(this.current < this.maxPage)this.getPageData(++this.current, callback);
    };
}

