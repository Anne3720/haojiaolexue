/*课程页面的章节目录显示*/
function getQueryString(name) {
  var reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i');
  var r = window.location.search.substr(1).match(reg);
  if (r != null) {
    return unescape(r[2]);
  }
  return null;
}  
var grade = getQueryString("grade");
var subject = getQueryString("subject");
var chapter = getQueryString("chapter");
$.ajax({
        method:'get',
        url:'/classes/getChapterList',
        data:{'grade':grade,'subjectID':subject},
        success: function(data){
            var cdata = $.parseJSON(data).data.ChapterList;
             console.log(cdata)
             if(cdata!==''){
                for (var i = 0; i <cdata.length; i++) {
                   $(".courseChapter").append('<li class="course-nav-item course-nav-item'+cdata[i].Chapter+'"><a href="/classes/classlist?grade=' + grade + '&subject=' + subject + '&chapter=' +cdata[i].Chapter+'">第' + cdata[i].Chapter + '章</a></li>');
                    
               }
                $(".course-nav-item" + chapter).addClass('on');
            }
             

        }
})