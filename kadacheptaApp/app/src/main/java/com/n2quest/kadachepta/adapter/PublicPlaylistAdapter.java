package com.n2quest.kadachepta.adapter;

import android.content.Context;
import android.database.DataSetObserver;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.VolleyLog;
import com.android.volley.toolbox.JsonObjectRequest;
import com.n2quest.kadachepta.AppController;
import com.n2quest.kadachepta.R;
import com.n2quest.kadachepta.constant.Constant;
import com.n2quest.kadachepta.model.MyplaylistItem;
import com.n2quest.kadachepta.model.PublicPlaylistItem;
import com.bumptech.glide.Glide;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

/**
 * Created by n2quest on 17/08/16.
 */


public class PublicPlaylistAdapter extends ArrayAdapter implements Constant {

    private  final ArrayList<PublicPlaylistItem> pubPlaylistArray;
    private  final Context context;
    View item;


    public PublicPlaylistAdapter(Context context, ArrayList<PublicPlaylistItem> pubPlaylistArray){
        super(context, R.layout.publicplaylist_item,pubPlaylistArray);
        this.pubPlaylistArray = pubPlaylistArray;
        this.context = context;

    }
    @Override
    public View getView(final int position, View convertView, ViewGroup parent){
        LayoutInflater inflater = (LayoutInflater)context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        item = inflater.inflate(R.layout.publicplaylist_item, parent, false);
        TextView playlistName = (TextView) item.findViewById(R.id.playlistName);
        playlistName.setText(pubPlaylistArray.get(position).getNamePlaylist());
        final TextView userName = (TextView) item.findViewById(R.id.playlistAuthor) ;

        String userId = pubPlaylistArray.get(position).getUserOwener();
        String url = BASE_BACKEND_URL + ENDPOINT_USER_INFO + userId + "?X-API-KEY=" + API_KEY;

        JsonObjectRequest jsonObjReq = new JsonObjectRequest(Request.Method.GET,
                url, null,
                new Response.Listener<JSONObject>() {

                    @Override
                    public void onResponse(JSONObject response) {

                        try {


                            String user = response.getString("username");

                            userName.setText("Author : " + user);


                        } catch (JSONException e) {
                            e.printStackTrace();

                        }

                    }
                }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError error) {
                VolleyLog.d("ARRE", "Error: " + error.getMessage());
                // hide the progress dialog

            }
        });


        AppController.getInstance().addToRequestQueue(jsonObjReq);


        return item;
    }

    @Override
    public void unregisterDataSetObserver(DataSetObserver observer) {
        if (observer != null) {
            super.unregisterDataSetObserver(observer);
        }
    }

}
