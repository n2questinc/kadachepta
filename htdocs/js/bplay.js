jQuery(function($) {
    "use strict";
    
    if ($(".singleSongPlayer").length) {
            $('.singleSong-jplayer').each(function(num, ele) {
                var temp_id = $(this).attr("id"),
                    temp_song = $(this).attr('data-mp3'),
                    temp_title = $(this).attr('data-title'),
                    temp_wrap = "#" + $(this).parents(".singleSongPlayer").attr("id");
                $(".singleSong-jplayer#" + temp_id).jPlayer({
                    play: function() {
                        $(this).jPlayer("pauseOthers"); // pause all players except this one.
                    },
                    ready: function() {
                        $(this).jPlayer("setMedia", {
                            mp3: temp_song,
                            title: temp_title
                        });
                    },
                    cssSelectorAncestor: temp_wrap,
                    loop: true,
                    remainingDuration: true,
                    volume: 1.0,
                    supplied: "mp3",
                    swfPath: "assets/js/jPlayer/jquery.jplayer.swf",
                });
            });
        }

    
    
    
    
});