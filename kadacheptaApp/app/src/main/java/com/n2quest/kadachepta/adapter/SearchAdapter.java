package com.n2quest.kadachepta.adapter;

import android.content.Context;
import android.database.DataSetObserver;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import com.n2quest.kadachepta.R;
import com.n2quest.kadachepta.constant.Constant;
import com.n2quest.kadachepta.model.MyplaylistItem;
import com.n2quest.kadachepta.model.SearchItem;

import java.util.ArrayList;

/**
 * Created by n2quest on 18/08/16.
 */


public class SearchAdapter extends ArrayAdapter implements Constant {

    private  final ArrayList<SearchItem> searchArray;
    private  final Context context;

    public SearchAdapter(Context context, ArrayList<SearchItem> searchArray){
        super(context, R.layout.search_item,searchArray);
        this.searchArray = searchArray;
        this.context = context;

    }
    @Override
    public View getView(final int position, View convertView, ViewGroup parent){
        LayoutInflater inflater = (LayoutInflater)context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        View item = inflater.inflate(R.layout.search_item, parent, false);
        TextView searchName = (TextView) item.findViewById(R.id.serchNameText);

        searchName.setText(searchArray.get(position).getnameSearchItem());


        return item;
    }

    @Override
    public void unregisterDataSetObserver(DataSetObserver observer) {
        if (observer != null) {
            super.unregisterDataSetObserver(observer);
        }
    }

}
