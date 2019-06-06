package com.example.hostelmanagement;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.Objects;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

import com.google.android.gms.tasks.OnSuccessListener;
import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.iid.InstanceIdResult;


public class MainActivity extends AppCompatActivity {
    private RequestQueue mQueue;

    EditText username,password;
    Button login;
    String newToken;

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        FirebaseInstanceId.getInstance().getInstanceId().addOnSuccessListener(this, new OnSuccessListener<InstanceIdResult>() {
            @Override
            public void onSuccess(InstanceIdResult instanceIdResult) {
                newToken = instanceIdResult.getToken();
                System.out.println(newToken);
            }
        });





        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        username=findViewById(R.id.username);
        password=findViewById(R.id.password);
        login = findViewById(R.id.login);
        mQueue = Volley.newRequestQueue(this);




        login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String url = "http://192.168.0.101/mng/html/ltr/auth.php?userid="+username.getText().toString()+"&password="+password.getText().toString();
                System.out.println(url);

                JsonObjectRequest request = new JsonObjectRequest(Request.Method.GET, url, null,
                        new Response.Listener<JSONObject>() {
                            @Override
                            public void onResponse(JSONObject response) {
                                try {
                                    String authentic = response.getString("success");
                                    System.out.println(authentic);

                                    if(Objects.equals(authentic, "true")) {
                                        Intent intent = new Intent(MainActivity.this, webviewapp.class);
                                        intent.putExtra("USERNAME", username.getText().toString());
                                        intent.putExtra("PASSWORD", password.getText().toString());
                                        intent.putExtra("TOKEN", newToken);
                                        System.out.println(newToken);
                                        startActivity(intent);
                                        Toast.makeText(MainActivity.this, "You have Authenticated Successfully", Toast.LENGTH_LONG).show();
                                    } else {
                                        Toast.makeText(MainActivity.this, "Authentication Failed", Toast.LENGTH_LONG).show();
                                    }

                                } catch (JSONException e) {
                                    e.printStackTrace();
                                }
                            }
                        }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        error.printStackTrace();
                    }
                });
                mQueue.add(request);
            }
        });

    }
}