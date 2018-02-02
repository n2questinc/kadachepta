package com.n2quest.kadachepta.adapter;

import android.content.Context;
import android.database.DataSetObserver;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.n2quest.kadachepta.R;
import com.n2quest.kadachepta.constant.Constant;
import com.n2quest.kadachepta.model.MyplaylistItem;
import com.bumptech.glide.Glide;

import java.util.ArrayList;

/**
 * Created by n2quest on 15/08/16.
 */
public class MyplaylistAdapter extends ArrayAdapter implements Constant {

    private  final ArrayList<MyplaylistItem> myPlaylistArray;
    private  final Context context;

    public MyplaylistAdapter(Context context, ArrayList<MyplaylistItem> myPlaylistArray){
        super(context,R.layout.myplaylist_item,myPlaylistArray);
        this.myPlaylistArray = myPlaylistArray;
        this.context = context;

    }
    @Override
    public View getView(final int position, View convertView, ViewGroup parent){
        LayoutInflater inflater = (LayoutInflater)context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        View item = inflater.inflate(R.layout.myplaylist_item, parent, false);
        TextView playlistName = (TextView) item.findViewById(R.id.myPlaylistName);

        playlistName.setText(myPlaylistArray.get(position).getNamePlaylist());


        return item;
    }

    @Override
    public void unregisterDataSetObserver(DataSetObserver observer) {
        if (observer != null) {
            super.unregisterDataSetObserver(observer);
        }
    }

}
