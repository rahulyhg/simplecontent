// Libary for formular elements

function openMediaLib()
{
  			document.getElementById('media_lib').style.display='block';
        document.getElementById('wrapper').style.opacity=0.2;
}
function closeMediaLib()
{
        document.getElementById('media_lib').style.display='none';
        document.getElementById('wrapper').style.opacity=1.0;
}         
function initIMG(fileName)
{
  document.getElementById('input_post_img_field').value = fileName;
  closeMediaLib();    
}
function generateURL()
{
  var title = document.getElementById('main-title-input').value;
  title = title.replace("ä", "u");
  title = title.replace("ü", "ue");
  title = title.replace("ö", "oe");
  title = title.replace("ß", "ss");
  title = title.replace(/ /g, "-");
  title = title.replace("!", "");
  title = title.replace("$", "");
  title = title.replace("\"", "");
  title = title.replace("(", "");
  title = title.replace("µ", "");
  title = title.replace(")", "");
  title = title.replace("]", "");
  title = title.replace("[", "");
  title = title.replace("?", "-?");
  title = title.toLowerCase();
  document.getElementById('url-input-field').value = title;
}