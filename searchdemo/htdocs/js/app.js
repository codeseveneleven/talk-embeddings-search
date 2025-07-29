

const template = document.getElementById('template');

document.querySelector('form').addEventListener('submit',(ev)=>{
   ev.preventDefault();
   ev.stopPropagation();
   let search = document.querySelector('input[type="search"]');
   let term = search.value;
   search.value='';

   document.getElementById('searchresult').innerHTML = '';
   document.getElementById('searchresult').appendChild(document.createElement('progress'));

   ajax({
      url: '/search.php',
      method: 'POST',
      payload: {'search': term}
   }).then(function (raw) {
      document.getElementById('searchresult').innerHTML = '';
      let data = JSON.parse(raw);
      data.forEach((elem) => {

         let result = template.content.cloneNode(true);
         result.querySelector('div').innerHTML = elem.text;
         result.querySelector('a').href=elem.slug;
         document.getElementById('searchresult').append(result);

      });

   });


});

var ajax = ajax || function(opts) {
   opts.method = opts.method || 'GET';
   opts.payload = opts.payload || null;
   if (!opts.url) return false;

   document.dispatchEvent(new CustomEvent('ajax-inprogress-start', {detail:opts,bubbles: true}));

   return new Promise(function(resolve,reject){
      var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      xhr.open(opts.method,opts.url,true);

      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.onload = function () {
         document.dispatchEvent(new CustomEvent('ajax-inprogress-end', {detail:'success',bubbles: true}));

         if (this.status >= 200 && this.status < 300) {
            resolve(xhr.response);
         } else {
            reject({
               status: this.status,
               statusText: xhr.statusText
            });
         }
      };
      xhr.onerror = function () {

         document.dispatchEvent(new CustomEvent('ajax-inprogress-end', {detail:'error',bubbles: true}));

         reject({
            status: this.status,
            statusText: xhr.statusText
         });
      };
      if (opts.headers) {
         Object.keys(opts.headers).forEach(function (key) {
            xhr.setRequestHeader(key, opts.headers[key]);
         });
      }
      var params = opts.payload;
      // We'll need to stringify if we've been given an object
      // If we have a string, this is skipped.
      if (params && typeof params === 'object') {
         params = Object.keys(params).map(function (key) {
            return encodeURIComponent(key) + '=' + encodeURIComponent(params[key]);
         }).join('&');
      }

      xhr.send(params);
   });
};
