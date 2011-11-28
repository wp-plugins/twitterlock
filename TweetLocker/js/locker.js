twttr.events.bind('tweet', function(event) {
    document.getElementById('hiddencontent').style.display = 'block';
    document.getElementById('hider').style.display = 'none';
});
    
twttr.events.bind('follow', function(event) {
    document.getElementById('hiddencontent').style.display = 'block';
    document.getElementById('hider').style.display = 'none';
});