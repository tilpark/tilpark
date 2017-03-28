/*
| -----------------------------------------------------------------------------
| Admin Required JavaScript
| -----------------------------------------------------------------------------
| ---------------------------------------------------------------------- WINDOW
| * get_site_url()
|
| ------------------------------------------------------------------- DOM START
|
| Genel sayfalar için gerekli dom fonsiyonlarını çalıştırıyoruz
|
| ------------------------------------------------------------------ IDE EDITOR
| * editor()
|
| -------------------------------------------------------------- SYSTEM GENERAL
| * get_notification_count()
| * get_notification_count_query()
| * get_notification()
| * play_sound()
| * imageHandler()
| * on_off()
|
| ---------------------------------------------------------------------- HELPER
| * hasClass()
| * parent()
| * getNextSiblings()
| * email_controller()
| * getJSON()
| * getOffset()
| * getCookie()
| * setClipboardText()
| * getXHR()
| * name_to_url()
| * addHours()
| * replaceAll()
|
*/


document.addEventListener("DOMContentLoaded", function(event) {

  // js-onload attr'si içerisindeki string'i function olarak comvert edip çalıştırıyoruz
  var js_onload = document.querySelectorAll("[js-onload]");
  for (var i = js_onload.length - 1; i >= 0; i--) {
    var func_string = js_onload[i].getAttribute('js-onload');
    eval(func_string);
  }



});



/**
 * @func get_site_url()
 * @desc Sayfanın adresini veriri
 * @param string
 * @return string
 */
function get_site_url(val='') {
  if ( val != "" ) {
    return window.site_url+val;
  } else {
    return window.site_url;
  }
} //.get_site_url()



/* -------------------------------------------------------------- IDE EDITOR */
/**
 * @func editor()
 * @desc textarea#content elementine tinymce editorünü etkinleştirir
 * @param selector, plugins, toolbar
 * @return
 */
function editor(param = {selector: "", plugins:"", toolbar:"", height: "500", menubar: false}) {
  var editor  = document.getElementById("content");
  var input   = document.createElement("INPUT");
  input.type  = "file";
  input.id    = "editor_file_input";
  input.style = "display: none";

  if ( param.selector == "" || param.selector == undefined ) { param.selector = '#content'; }
  if ( param.menubar == "" || param.menubar == undefined ) { param.menubar = false; }
  if ( param.plugins == "" || param.plugins == undefined ) param.plugins = ['advlist autolink lists link image print preview', 'searchreplace wordcount code fullscreen pre_lines', 'insertdatetime nonbreaking save table contextmenu directionality', 'paste textcolor colorpicker textpattern imagetools codesample codemirror pre_html code_html'];
  if ( param.toolbar == "" || param.toolbar == undefined ) param.toolbar = 'styleselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright | bullist numlist | link image print preview media codesample pre_html code_html code';

  tinymce.init({
    selector: param.selector,
    plugins: param.plugins,
    menubar : param.menubar,
    toolbar1: param.toolbar,
    theme: 'modern',
    height: param.height,
    nonbreaking_force_tab: true,
    language: 'tr_TR',
    external_plugins: { codemirror: get_site_url('includes/lib/tinymce/plugins/codemirror/plugin.js') },
    content_css: [ get_site_url('content/themes/default/css/bootstrap.min.css'), get_site_url('content/themes/default/css/app.css')],
    codemirror: { indentOnInit: true, fullscreen: true, path: 'CodeMirror', config: { lineNumbers: true }, theme: "monokai"},
    table_default_attributes: { class: 'table-bordered'},
    // image upload
    file_browser_callback: function (field_name, url, type, win) {
      input.click();

      input.onchange = function () {
        imageHandler(this.files[0], function(src){
           win.document.getElementById(field_name).value = src;
        });
      }
    },
    init_instance_callback: function (editor) {
      editor.on('keyDown', function (e) {

        if ( e.keyCode == 13 && !e.shiftKey ) {
          var event = new Event('keydown', {
            keyCode: e.keyCode,
          });

          document.querySelector(param.selector).dispatchEvent(event);
        }
      });
    }
  });
} //. editor()






/* --------------------------------------------------------- SYSTEM GENERAL */
/**
 * @func get_notification_count()
 * @desc get_notification_count_query() fonsiyonunu her saniye başı çalıştırır
 * @param (box: "task | message", elem: "selector")
 * @return
 */
function get_notification_count(param) {
  get_notification_count_query(param);

  setInterval(function() {
    get_notification_count_query(param);
  }, 1000);
} //.get_notification_count()






/**
 * @func get_notification_count_query()
 * @desc bildirim kutusuna göre bildirim var mı yok mu sorgusu yapar
 * @param object (box: "task | message", elem: "selector")
 * @return
 */
function get_notification_count_query(param) {
  getXHR({ 'method': 'get', 'url': get_site_url('admin/user/getNotification.php?query_type=count&session_id='+window.session_id+'&box='+param.box)}, function(data) {
    if ( data == "empty" ) {
      var count = 0;
    } else {
      var count = data;
      var elem = document.querySelector(param.elem);

      if ( count != elem.innerHTML ) {
        if ( count > parseInt(elem.innerHTML) ) { playSound('message'); }
        elem.innerHTML = count;
      }
    }
  });
} //.get_notification_count_query()






/**
 * @func get_notification()
 * @desc bildirim list'sindeki verileri dinamik olarak günceller
 * @param string ("selector", "task | message")
 * @return
 */
function get_notification(elem, box) {
  if ( hasClass(elem, 'dropdown-menu') ) {
    if ( hasClass(parent(elem, '.dropdown'), 'open') ) {
      return false;
    }
  }

  getXHR({ 'method': 'get', 'url': get_site_url('admin/user/getNotification.php?query_type=list&session_id='+window.session_id+'&box='+box)}, function(data) {
    if ( data != "empty" ) {
      elem.innerHTML = data;
    }
  });
} //.get_notificaion()






/**
 * @func playSound()
 * @desc content/themes/default/sound içerisindeki çağrılan sesi 1 keres sayfada çalar
 * @param string
 * @return sound 
 */
function playSound(filename){   
  var body = document.querySelector('body');
  var audio = document.createElement("audio");
  audio.setAttribute("autoplay", "autoplay");
  audio.innerHTML = '<source src="' + get_site_url('content/themes/default/sound/'+filename) + '.mp3" type="audio/mpeg" /><source src="' + get_site_url('content/themes/default/sound'+filename) + '.ogg" type="audio/ogg" /><embed hidden="true" autostart="true" loop="false" src="' + get_site_url('content/themes/default/sound'+filename) +'.mp3" />';
  body.appendChild(audio);
}



/**
 * @func chat_list()
 * @desc message/detail.php sayfasındaki chat'i dinamic olarak günceller
 * @param string
 * @return html 
 */
function chat_list() {
  var chat_list = document.querySelector(".chat-list");
  if ( chat_list ) {
    elem_scroll_bottom(chat_list);

    // OLD Message
    chat_list.onscroll = function() {
      if ( chat_list.scrollTop == 0 ) {
        parent(chat_list, '.chat-container').classList.add("loader");

        if ( chat_list.children[0] ) {
          var query_message = chat_list.getAttribute("id");
          var list_old_message = chat_list.children[0].getAttribute("id");

          if ( !list_old_message ) {
            var list_old_message = chat_list.children[0].children[0].getAttribute("id");
          }

          getXHR({ 'method': 'get', 'url': get_site_url('admin/user/getMessage.php?query_message='+ query_message +'&get_message=old&list_old_message='+ list_old_message +'&session_id='+window.session_id)}, function(data) {
            if ( data != "empty" && data != false ) {
              setTimeout(function() { parent(chat_list, '.chat-container').classList.remove("loader"); }, 500);

              var div = document.createElement("div");
              div.setAttribute("class", 'message-elem');
              div.innerHTML = data;
              chat_list.insertBefore(div, chat_list.firstChild);
              chat_list.scrollTop = 100;
            } else { parent(chat_list, '.chat-container').classList.remove("loader"); }
          });
        }
      }
    }
    // OLD Message
    
    // NEW Message
    window.getMessage = setInterval("get_new_message('new')", 1000);
    // NEW Message    
  } else { return false; }
} //.chat_list()





/**
 * @func get_new_message()
 * @desc son mesajı chat-list içerisine ekler
 * @param string
 * @return html 
 */
function get_new_message(add_class) {
  var chat_list = document.querySelector(".chat-list");
  var last_view_message = chat_list.lastElementChild.children[0].getAttribute('id');
  getXHR({ 'method': 'get', 'url': get_site_url('admin/user/getMessage.php?query_message='+ chat_list.getAttribute('id') +'&last_view_message='+ last_view_message +'&get_message=new&session_id='+window.session_id)}, function(data) {
    if ( data != "empty" && data != false ) {
      var matches = data.match(/<til>([\s\S]*?)<\/til>/gmi);
      var chat_list = document.querySelector(".chat-list");
      for (var i = matches.length - 1; i >= 0; i--) {
        var div = document.createElement("div");
        div.innerHTML = matches[i].replace("<til>", '');
        div.setAttribute("class", "message-elem "+add_class);
        chat_list.appendChild(div);
        elem_scroll_bottom(chat_list);
        
        if ( i == 0) div.setAttribute("class", "message-elem "+add_class);
        setTimeout(function() {
         div.classList.remove(add_class); 
         for (var i = chat_list.children.length - 1; i >= 0; i--) { chat_list.children[i].classList.remove(add_class); }
        }, 2500);
        document.title = "(1) " + chat_list.lastElementChild.children[0].getAttribute("title") + " - " + chat_list.lastElementChild.children[0].getAttribute("username");
      } 
    }
  });
} //.get_new_message





/**
 * @func elem_scroll_bottom()
 * @desc bir listenin liste elemanlarına göre scroll bottom'unu hesaplar
 * @param elem
 * @return elem.scrolTop 
 */
function elem_scroll_bottom(chat_list) {
  // scrollBottom
  var height = 0;
  for (var i = chat_list.children.length - 1; i >= 0; i--) {
    height = height + chat_list.children[i].offsetHeight;
  }
  chat_list.scrollTop = height;
  // scrollBottom
} //.elem_scroll_bottom()








/**
 * @func send_message()
 * @desc message gönderir
 * @param empty
 * @return  
 */
function send_message($this, type) {
  var message   = $this.querySelector('textarea');
  if ( !message ) $this.querySelector('input[type="text"]');

  // fast send kontrol
  var date = new Date();
  var cookie_date = new Date(getCookie('last_send_date'));
  if ( cookie_date > date.addSecond(-1) ) {
    tinyMCE.get(message.getAttribute('id')).setContent('');
    return false;
  }

  document.cookie = "last_send_date="+Date()+";";
  // fast send kontrol

  if ( message ) {
    var content   = tinyMCE.get(message.getAttribute('id')).getContent();
    tinyMCE.get(message.getAttribute('id')).setContent('');
    tinymce.execCommand('mceFocus', false, message.getAttribute('id'));

    var top_id    = $this.querySelector('#top_id');
    var receiver  = $this.querySelector('#receiver');

    if ( content.length > 3 ) {
      var form = new FormData();
      form.append("message", content);
      form.append("top_id", top_id.value);
      form.append("receiver", receiver.value);

      getXHR({ 'method': 'POST', 'url' : get_site_url('admin/user/sendMessage.php?session_id='+window.session_id), 'send': form  }, function(data) {
        if ( data != "empty" && data != false ) {
          get_new_message('send');
          
          clearInterval(window.getMessage);
          window.getMessage = setInterval("get_new_message('new')", 1000);
        } else { return false; }
      });
    } else { alert('en az 3 kelime'); }
  } else { return false; }
  return false;
} //.send_message()




/**
 * @func imageHandler()
 * @desc FILE ile image verisi gelir ise callback ile resim url'leri geri verilir
 * @param empty
 * @return callback
 */
function imageHandler(image, callback) {
  var data = new FormData();
  data.append('image', image);

  var xhr = new XMLHttpRequest();
  xhr.open('POST', get_site_url('includes/upload.php?session_id='+window.session_id), true);

  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        if ( xhr.responseText == "") {
          console.log("Dosya izni veya resmin 5mb'den büyük olmadığından emin olun");
        } else {
          callback(xhr.responseText);
        }
      }
    }
  }
  xhr.send(data);
} // imageHandler()








/**
 * @func on_off()
 * @desc class var ise siler yok ise ekler
 * @param string
 * @return
 */
function on_off($this, elem, $this_class="active", elem_class="open") {
  if ( hasClass($this, $this_class) ) {
    elem.classList.remove(elem_class);
    $this.classList.remove($this_class);
  } else {
    $this.classList.add($this_class);
    elem.classList.add(elem_class);
  }
} //.delete_option





/* ------------------------------------------------------------------ HELPER */
/**
 * @func hasClass()
 * @desc elemen class'ı içerisinde aranan class var mı yok mu?
 * @param element, string
 * @return true / false
 */
function hasClass(element, thatClass) {
  if ( (" " + element.className + " ").replace(/[\n\t]/g, " ").indexOf(" "+ thatClass +" ") > -1 ) {
    return true;
  } else {
    return false;
  }
} //.hasClass()






/**
 * @func getNextSiblings()
 * @desc like jQuery.next()
 * @param element
 * @return string
 */
function getNextSiblings(elem) {
  var sibs = [];
  while (elem = elem.nextSibling) {
      if (elem.nodeType === 3) continue; // text node
      sibs.push(elem);
  }
  return sibs;
} // getNextSiblings()






/**
 * @func email_controller()
 * @desc email kontrolü yapar
 * @param string
 * @return true / false
 */
function email_controller(email) {
  var reg = new RegExp("^"+"([abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0-9_\.\-]+)"+"@"+"([abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0-9_\.\-]+)"+"[\.]"+"([abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0-9_\.\-]+)"+"$", "g");
  if ( reg.test(email) ) {
    return true;
  } else {
    return false;
  }
}







/**
 * @func getJSON()
 * @desc url'si verilen json dosyasının veririlerini basar
 * @param string
 * @return callback
 */
function getJSON(url, callback) {
  var xhr = new XMLHttpRequest();
  xhr.open('GET', url);
  xhr.send(null);
  window.getjsondata;

  xhr.onreadystatechange = function () {
    var DONE = 4;
    var OK = 200;
    if (xhr.readyState === DONE) {
      if (xhr.status === OK) {
        callback(xhr.responseText);
        window.getjsondata = xhr.responseText;
      }
    }
  }

  setTimeout(function(){
    return window.getjsondata;
  }, 500);
} //getJSON()






/**
 * @func getOffset()
 * @desc element'in sayfanın üstüne ve soluna olan uzaklığını hesapşlar
 * @param string
 * @return object (top, let)
 */
function getOffset( element ) {
  var top = 0, left = 0;
    do {
        top += element.offsetTop  || 0;
        left += element.offsetLeft || 0;
        element = element.offsetParent;
    } while(element);

    return {
        top: top,
        left: left
    };
} //.getOffset()






/**
 * @func getCookie()
 * @desc JavaSript'in anlık cerezlerini veirir
 * @param string
 * @return string
 */
function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);

  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
        c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
    }
  }
  return "";
} //.getCookie()






/**
 * @func parent()
 * @desc verilen elementi ilk üst elementini bulur
 * @param element, selector
 * @return element
 */
function parent(el, selector) {
    var matchesFn;

    // find vendor prefix
    ['matches','webkitMatchesSelector','mozMatchesSelector','msMatchesSelector','oMatchesSelector'].some(function(fn) {
        if (typeof document.body[fn] == 'function') {
            matchesFn = fn;
            return true;
        }
        return false;
    })

    var parent;

    // traverse parents
    while (el) {
        parent = el.parentElement;
        if (parent && parent[matchesFn](selector)) {
            return parent;
        }
        el = parent;
    }

    return null;
} //.parent()






/**
 * @func setClipboardText()
 * @desc verilen text'i kopyalar
 * @param text
 * @return
 */
function setClipboardText(text){
    var id = "mycustom-clipboard-textarea-hidden-id";
    var existsTextarea = document.getElementById(id);

    if(!existsTextarea){
        var textarea = document.createElement("textarea");
        textarea.id = id;
        // Place in top-left corner of screen regardless of scroll position.
        textarea.style.position = 'fixed';
        textarea.style.top = 0;
        textarea.style.left = 0;

        // Ensure it has a small width and height. Setting to 1px / 1em
        // doesn't work as this gives a negative w/h on some browsers.
        textarea.style.width = '1px';
        textarea.style.height = '1px';

        // We don't need padding, reducing the size if it does flash render.
        textarea.style.padding = 0;

        // Clean up any borders.
        textarea.style.border = 'none';
        textarea.style.outline = 'none';
        textarea.style.boxShadow = 'none';

        // Avoid flash of white box if rendered for any reason.
        textarea.style.background = 'transparent';
        document.querySelector("body").appendChild(textarea);
        existsTextarea = document.getElementById(id);
    }else{

    }

    existsTextarea.value = text;
    existsTextarea.select();

    try {
        var status = document.execCommand('copy');
        if(!status){
        }else{
        }
    } catch (err) {
    }
} //.setClipboardText()






/**
 * @func getXHR()
 * @desc XMLHttpRequest işlemini gerçekleştirir
 * @param object, callback
 * @return string
 */
function getXHR(set="", callback) {
  var object = new Object();
  object = {
    'method': 'get',
    'url':    '',
    'send':    ''
  };

  for (var key in object) {
    if ( set[key] == "" && set[key] == undefined ) {
      set[key] = object[key];
    }
  }

  var xhr = new XMLHttpRequest();
  xhr.open(set.method, set.url, true);
  xhr.onload = function(e) {
    if (xhr.status == 200) {
      if ( xhr.responseText == "" ) {
        callback('empty');
      } else { callback(xhr.responseText); }
    } else { callback(false) }
  };
  xhr.send(set.send);
} //.getXHR()





/**
 * @func name_to_url()
 * @desc self string verir
 * @param string
 * @return string
 */
function name_to_url(name) {
  name = name.toLowerCase(); // lowercase

  var try_char = ['ı', 'ö', 'ç', 'ü', 'ğ', 'ş', 'ı'];
  var eng_char = ['i', 'o', 'c', 'u', 'g', 's', 'i'];
  for (var i = try_char.length - 1; i >= 0; i--) {
    name = name.replaceAll(try_char[i], eng_char[i]);
  }

  name = name.replace(/^\s+|\s+$/g, ''); // remove leading and trailing whitespaces
  name = name.replace(/\s+/g, '-'); // convert (continuous) whitespaces to one -
  name = name.replace(/[^a-z-]/g, ''); // remove everything that is not [a-z] or -
  return name;
} //.name_to_url()




  /**
   * @func addHours()
   * @desc verilen zamana saat ekler
   * @param string
   * @return string
   */
  Date.prototype.addHours = function(h) {
    this.setTime(this.getTime() + (h*60*60*1000));
    return this;
  } //.addHours()


  /**
   * @func addSecond()
   * @desc verilen zamana saniye ekler
   * @param string
   * @return string
   */
  Date.prototype.addSecond = function(h) {
    this.setTime(this.getTime() + (h*1000));
    return this;
  } //.addSecond()


  /**
   * @func replaceAll()
   * @desc replace all
   * @param string
   * @return string
   */
  String.prototype.replaceAll = function(search, replacement) {
      var target = this;
      return target.replace(new RegExp(search, 'g'), replacement);
  };//.replaceAll


