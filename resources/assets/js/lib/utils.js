export function getScript(source, callback) {
    var script = document.createElement('script');
    var prior = document.getElementsByTagName('script')[0];
    script.async = 1;

    script.onload = script.onreadystatechange = function( _, isAbort ) {
        if(isAbort || !script.readyState || /loaded|complete/.test(script.readyState) ) {
            script.onload = script.onreadystatechange = null;
            script = undefined;

            if(!isAbort) { if(callback) callback(); }
        }
    };

    script.src = source;
    prior.parentNode.insertBefore(script, prior);
}

export function createScript(src) {
  var scriptTag = document.createElement(tag);
  var firstScriptTag = document.getElementsByTagName(tag)[0];
  scriptTag.src = src;
  firstScriptTag.parentNode.insertBefore(scriptTag, firstScriptTag);
}
