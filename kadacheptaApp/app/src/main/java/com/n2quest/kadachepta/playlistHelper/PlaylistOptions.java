package com.n2quest.kadachepta.playlistHelper;

/**
 * Created by n2quest on 15/08/16.
 */


public class PlaylistOptions {

    private String playlistName;
    private String playlistId;

    public PlaylistOptions(String playlistId, String playlistName) {
        super();
        this.playlistId = playlistId;
        this.playlistName = playlistName;
    }


    public String getPlaylistName(){
        return playlistName;
    }
    public void setPlaylistname(String playlistName){
        this.playlistName = playlistName;
    }
    public  String getPlaylistId(){
        return playlistId;
    }
    public  void  setPlaylistId(String playlistId){
        this.playlistId = playlistId;
    }
}
