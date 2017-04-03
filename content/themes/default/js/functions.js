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
| * imageHandler()
|
| ---------------------------------------------------------------------- HELPER
| * hasClass()
| * parent()
| * getNextSiblings()
| * email_controller()
| * getJSON()
| * getOffset()
| * getCookie()
| * getXHR()
| * play_sound()
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
    content_css: [ get_site_url('content/themes/default/css/bootstrap.min.css'), get_site_url('content/themes/default/css/app.css'), get_site_url('content/themes/default/css/app-minan.css')],
    codemirror: { indentOnInit: true, fullscreen: true, path: 'CodeMirror', config: { lineNumbers: true }, theme: "monokai"},
    table_default_attributes: { class: 'table-bordered'},
    // image upload
    file_browser_callback: function (field_name, url, type, win) {
      input.click();

      input.onchange = function () {
        imageHandler(this.files[0], function(src){
          if ( src == false) { src = ""; }
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

      // focus
      if ( param.onfocus ) {
        editor.on('focus', function (e) {
          var event = new Event('focus');
          document.querySelector(param.selector).dispatchEvent(event);
        });
      }

      // focusout
      if ( param.onfocusout ) {
        editor.on('focusout', function (e) {
          var event = new Event('focusout');
          document.querySelector(param.selector).dispatchEvent(event);
        });
      }

      // keyup
      if ( param.onkeyup ) {
        editor.on('keyup', function (e) {
          var event = new Event('keyup');
          document.querySelector(param.selector).dispatchEvent(event);
        });
      }

      // keypress
      if ( param.onkeypress ) {
        editor.on('keypress', function (e) {
          var event = new Event('keypress');
          document.querySelector(param.selector).dispatchEvent(event);
        });
      }
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
        elem.innerHTML = count;
        if ( count > parseInt(elem.innerHTML) ) { playSound('message'); }
        if ( count > 0 ) { elem.classList.add('active'); } else { elem.classList.remove('active'); }
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
function get_notification(elem, box, open_control=true) {
  if ( open_control ) {
    if ( hasClass(elem, 'dropdown-menu') ) {
      if ( hasClass(parent(elem, '.dropdown'), 'open') ) {
        return false;
      }
    }
  }

  getXHR({ 'method': 'get', 'url': get_site_url('admin/user/getNotification.php?query_type=list&session_id='+window.session_id+'&box='+box)}, function(data) {
    if ( data != "empty" && data != false ) {
      elem.innerHTML = data;
    }
  });
} //.get_notificaion()







/**
 * @func set_notification()
 * @desc bildirim durmunu değiştirir
 * @param dom element, object
 * @return event onchnage
 */
function set_notification($this, object) {
  getXHR({'method': 'POST', 'url': get_site_url('admin/user/setNotification.php?session_id='+window.session_id+'&args='+JSON.stringify(object))}, function(data) {
    if ( data != 'empty' && data != false ) {
      var data = JSON.parse(data);
      $this.setAttribute('status', data.status);
      $this.setAttribute('read-it', data.read_it);

      var event = new CustomEvent('change');
      $this.dispatchEvent(event);
    } else { return false; }
  });
} //.set_notification()




/**
 * @func notification_readit_button()
 * @desc bildirim durmunu değiştiren button için gerekli js
 * @param dom element
 * @return js operation
 */
function notification_readit_button($this) {
  if ( $this.getAttribute('read-it') == '1' ) {
    parent($this, '.message-list').classList.remove('bold');

    $this.setAttribute('data-wenk', 'okunmadı');

    $this.querySelector('i').classList.add('fa-circle-o');
    $this.querySelector('i').classList.remove('fa-circle');
  } else {
    parent($this, '.message-list').classList.add('bold');

    $this.setAttribute('data-wenk', 'okundu');

    $this.querySelector('i').classList.remove('fa-circle-o');
    $this.querySelector('i').classList.add('fa-circle');
  }
} //.notification_readit_button()



/**
 * @func notification_delete_button()
 * @desc bildirimi gizler
 * @param dom element
 * @return js operation
 */
function notification_delete_button($this) {
  if ( $this.getAttribute('status') == '0' ) {
    parent($this, '.message-list').classList.add('delete');
    setTimeout(function() {
      get_notification(parent($this, '.dropdown-message-list'), 'notification', false);
      parent($this, '.message-list').remove();
    }, 350);
  }
} //.notification_delete_button()





/**
 * @func notification_all_readit_button()
 * @desc listedeki tüm elementlerin bildirim durmunu değiştirir
 * @param dom element
 * @return js operation
 */
function notification_all_readit_button($this, $list) {
  var elem    = $list.querySelectorAll('.message-list');

  for (var i = elem.length - 1; i >= 0; i--) {
    set_notification($this, {'id': elem[i].className.match(/notification-(.*?) /gmi)[0].replace('notification-', '').trim(), 'status': '1', 'read_it': '1'})
  } // endfor

  get_notification(parent($this, '.dropdown-message-list'), 'notification', false);
} //.notification_all_readit_button()



/**
 * @func notification_all_delete_button()
 * @desc listedeki tüm bildirimleri gizler
 * @param dom element
 * @return js operation
 */
function notification_all_delete_button($this, $list) {
  var elem    = $list.querySelectorAll('.message-list');

  for (var i = elem.length - 1; i >= 0; i--) {
    set_notification($this, {'id': elem[i].className.match(/notification-(.*?) /gmi)[0].replace('notification-', '').trim(), 'status': '0', 'read_it': '1'});
  } // endfor

  setTimeout(function() { get_notification(parent($this, '.dropdown-message-list'), 'notification', false); }, 300);
} //.notification_all_delete_button()




/**
 * @func chat_list()
 * @desc message/detail.php sayfasındaki chat'i dinamic olarak günceller
 * @param string
 * @return html
 */
function chat_list(type) {
  if ( !type || (type != "task" && type != "message") ) { window.message_type = "message"; } else { window.message_type = type; }

  var matches;
  var chat_list = document.querySelector(".chat-list");

  window.get_new_message_control = true;
  window.get_message_control     = true;
  window.get_last_message_id    = chat_list.lastElementChild.getAttribute('id');
  window.get_first_message_id   = chat_list.firstElementChild.getAttribute('id');

  get_new_message('get', window.message_type);

  chat_list.scrollTop = chat_list.scrollHeight;
  window.get_message_control = true;

  chat_list.onscroll = function() {
    if ( chat_list.scrollTop < 10 ) {
      parent(chat_list, '.chat-container').classList.add("loader");
      if ( type == "message" ) { old_type = "mess-reply" } else { old_type = "task-reply"; }

      if ( window.get_message_control == true ) {
        window.get_message_control = false;
      } else { return false; }

      getXHR({ 'method': 'get', 'url': get_site_url('admin/user/getMessage.php?type='+ old_type +'&query_message='+ chat_list.getAttribute("id") +'&get_message=old&list_old_message='+ window.get_first_message_id +'&session_id='+window.session_id)}, function(data) {
        if ( data != "empty" && data != false ) {
          if ( matches = data.match(/<div class="message-elem *?([\s\S]*?)<\/div><!--\/ \.message-elem \/-->/gmi) ) {
            for ( var i = matches.length - 1; i >= 0; i-- ) {
              setTimeout(function() { parent(chat_list, '.chat-container').classList.remove("loader"); }, 500);

              var div = document.createElement("DIV");
              div.innerHTML = matches[i];
              div = div.children[0];

              if ( !document.querySelector(".message-"+div.getAttribute('id')) ) {
                if ( i == 0 ) { window.get_first_message_id = div.getAttribute('id'); }

                if ( chat_list.insertBefore(div, chat_list.firstChild) ) {
                  chat_list.scrollTop = 20;
                  window.get_message_control = true;
                } else { window.get_message_control = true; }
              } else {  window.get_message_control = true;}
            } // end for
          } else { window.get_message_control = true; }
        } else { parent(chat_list, '.chat-container').classList.remove("loader"); window.get_message_control = true; }
      });
    } // is scrollTop < 20
  } // onscroll

  // NEW Message
  window.getMessage = setInterval("get_new_message('get', '"+ window.message_type +"')", 1000);
  // NEW Message
} //.chat_list()





/**
 * @func get_new_message()
 * @desc son mesajı chat-list içerisine ekler
 * @param string
 * @return html
 */
function get_new_message(class_name="", type="message") {
  var chat_list = document.querySelector(".chat-list");
  if ( window.get_new_message_control == true ) {
    window.get_new_message_control = false;
  } else { return false; }

  var matches;

  if ( type == "message" ) { get_type = "mess-reply" } else { get_type = "task-reply"; }

  getXHR({ 'method': 'get', 'url': get_site_url('admin/user/getMessage.php?type='+ get_type +'&query_message='+ chat_list.getAttribute('id') +'&last_view_message='+ window.get_last_message_id +'&get_message=new&session_id='+window.session_id), timeout: true}, function(data) {
    clearInterval(window.getMessage);

    if ( data != "empty" && data != false ) {
      if ( matches = data.match(/<div class="message-elem *?([\s\S]*?)<\/div><!--\/ \.message-elem \/-->/gmi) ) {
        for ( var i = matches.length - 1; i >= 0; i-- ) {
          var div = document.createElement("DIV");
          div.innerHTML = matches[i];
          div = div.children[0];

          if ( !document.querySelector(".message-"+div.getAttribute('id')) ) {
            var chat_list = document.querySelector(".chat-list");

            if ( chat_list.appendChild(div) ) {
              chat_list.scrollTop = chat_list.scrollHeight;
              if ( window.innerWidth < 767 ) {
                document.querySelector("body").scrollTop = document.querySelector("body").scrollHeight;
              } else {
                document.querySelector("body").scrollTop = getOffset(chat_list).top;
              }
              setTimeout(function() { if ( chat_list.scrollTop != chat_list.scrollHeight ) { chat_list.scrollTop = chat_list.scrollHeight; } }, 500);

              if ( class_name == 'get' ) { document.title = "(1) " + chat_list.lastElementChild.getAttribute("title") + " - " + chat_list.lastElementChild.getAttribute("username"); }

              window.get_last_message_id = div.getAttribute('id');
              window.get_new_message_control = true;

              window.getMessage = setInterval("get_new_message('get', '"+ window.message_type +"')", 1000);
            } else { window.get_new_message_control = true; }
          } else { window.get_new_message_control = true; return false; }
        } // end for
      }
    } else {
       window.get_new_message_control = true;
       window.getMessage = setInterval("get_new_message('get', '"+ window.message_type +"')", 1000);
       return false;
     }
  });
} //.get_new_message()







/**
 * @func send_message()
 * @desc message gönderir
 * @param empty
 * @return
 */
function send_message($this, type="message") {
  var message   = $this.querySelector('textarea');
  if ( !message ) { var message = $this.querySelector('input[type="text"]'); }

  if ( message ) {
    var top_id  = $this.querySelector('#top_id');

    if ( message.tagName != 'INPUT' ) {
      var content = tinyMCE.get(message.getAttribute('id')).getContent();
      tinyMCE.get(message.getAttribute('id')).setContent('');
      tinymce.execCommand('mceFocus', false, message.getAttribute('id'));
    } else { var content = message.value; message.value = ""; }

    if ( content.length >= 3 ) {
      var form = new FormData();
      form.append("message", content);
      form.append("top_id", top_id.value);

      if ( type == 'message' ) form.append("receiver", $this.querySelector('#receiver').value);
      if ( type == 'task' ) form.append("task_id", $this.querySelector('#task_id').value);

      clearInterval(window.getMessage);
      getXHR({ 'method': 'POST', 'url' : get_site_url('admin/user/sendMessage.php?session_id='+window.session_id+'&type='+type), 'send': form  }, function(data) {
        if ( data == 'true' ) {
          if ( get_new_message('send', type) ) {
            return true;
          } else { return false; }
        } else { return false; }
      });
    } else { alert('en az 3 kelime'); }
  } else { return false; }
  return false;
} //.send_message()




function til_dynamic_tab($this, $elem) {
  var all_tabs = document.querySelectorAll('.til-dynamic-tab');
  for (var i = 0; i < all_tabs.length; i++) { if ( $elem != all_tabs[i] ) all_tabs[i].classList.remove('open'); }

  var all_btn = document.querySelectorAll('[dynamic-tab-btn]');
  for (var i = 0; i < all_btn.length; i++) { if ( $this != all_btn[i] ) all_btn[i].classList.remove('active'); }

  if ( hasClass($this, 'active') ) {
    $this.classList.remove('active');
    $elem.classList.remove('open');
  } else {
    $this.classList.add('active');
    $elem.classList.add('open');
  }
} //.til_dynamic_tab()



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
          callback(false);
        } else {
          callback(xhr.responseText);
        }
      }
    }
  }
  xhr.send(data);
} // imageHandler()



function clear_writing(obj) {
  getXHR({ 'method' : 'get', 'url': get_site_url('admin/user/message-writing.php?top_id=' + window.set_writing.top_id + '&clear_writing=true&session_id=' + window.session_id  ) }, function(data) {
    if ( data != 'empty' && data != false ) {
      if ( data == 'true' ) {
        return true;
      }
    } else { return false; }
  });
}




function set_writing(obj) {
  if ( obj ) {
    getXHR({ 'method' : 'get', 'url': get_site_url('admin/user/message-writing.php?top_id=' + window.set_writing.top_id + '&set_value=' + obj.set_value + '&session_id=' + window.session_id  ) }, function(data) {
      if ( data != 'empty' && data != false ) {
        if ( data == 'true' ) {

          return true;
        }
      } else { return false; }
    });
  } else { return false; }
} //.set_writing



function get_writing(selector) {
  setInterval(function() {
    getXHR({ 'method' : 'get', 'url': get_site_url('admin/user/message-writing.php?top_id=' + window.set_writing.top_id + '&&get=true&session_id=' + window.session_id  ) }, function(data) {
      if ( data != 'empty' ) {
        var elem = document.querySelector(selector);

        if ( data == 1 ) {
          elem.classList.add('writing');
          elem.classList.remove('deleting');
        } else if ( data == 2 ) {
          elem.classList.remove('writing');
          elem.classList.add('deleting');
        } else {
          elem.classList.remove('writing');
          elem.classList.remove('deleting');
        }
      } else { return false; }
    });
  }, 1000);

  setInterval(function() { clear_writing({'set_value':'0'}); }, 5000);
} //



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
  xhr.onload = function(e) {
    if (xhr.status == 200) {
      if ( xhr.responseText == "" ) {
        callback('empty');
      } else {
        callback(xhr.responseText);
       }
    } else { callback(false) }
  };
  xhr.open(set.method, set.url, true);
  xhr.send(set.send);
} //.getXHR()




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
} //.playSound()




/**
 * @func add_or_remove_class()
 * @desc add or remove class
 * @param dom elem, dom elem, object, object
 * @return add or remove class
 */
function add_or_remove_class($btn, $elem, btn_obj={'active': 'active'}, elem_obj={'active': 'open'}) {
  if ( hasClass($btn, btn_obj.active) ) {
    $btn.classList.remove(btn_obj.active);
    $elem.classList.remove(elem_obj.active);
  } else {
    $btn.classList.add(btn_obj.active);
    $elem.classList.add(elem_obj.active);
  }
} //.add_or_remove_class()






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
