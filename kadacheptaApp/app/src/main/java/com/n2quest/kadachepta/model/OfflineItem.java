package com.n2quest.kadachepta.model;

/**
 * Created by n2quest on 19/08/16.
 */
public class OfflineItem {

    String offtrack_name;
    String offtrack_file;


    public OfflineItem(String offtrack_name, String offtrack_file ) {

        super();
        this.offtrack_name = offtrack_name;
        this.offtrack_file = offtrack_file;


    }

    public String getOfftrack_name(){
        return offtrack_name;
    }

    public void setOfftrack_name (String offtrack_name){
        this.offtrack_name = offtrack_name;

    }

    public String getOfftrack_file (){
        return offtrack_file;
    }

    public void setOfftrack_file (String offtrack_file){
        this.offtrack_file = offtrack_file;

    }
}
