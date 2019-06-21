var profane_words=new Array("dog","badword-2","badword-3");
function profanity(txt)
{
var alert_arr=new Array;
var alert_count=0;
var compare_text=txt;
var total = profane_words.length;
var matches = 0;
 
for( var i = 0; i < total; i++ )
{
if(compare_text.indexOf(profane_words[i]) > -1)
{
var message=1;
return message;
break;
}
}
}