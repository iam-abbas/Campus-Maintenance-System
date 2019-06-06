package com.example.hostelmanagement;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.content.Intent;


public class webviewapp extends AppCompatActivity {
    private WebView webView;

    String url = "http://192.168.0.101/mng/html/ltr/login.php";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        Bundle bundle = getIntent().getExtras();
        String username = bundle.getString("USERNAME");
        String password = bundle.getString("PASSWORD");
        String token = bundle.getString("TOKEN");

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_webviewapp);

        webView = findViewById(R.id.webview);
        webView.setWebViewClient(new WebViewClient());
        webView.loadUrl("http://192.168.0.101/mng/html/ltr/mob-auth.php?userid="+username+"&password="+password+"&token="+token);

        WebSettings webSettings = webView.getSettings();
        webSettings.setJavaScriptEnabled(true);
    }

    @Override
    public void onBackPressed() {
        if (webView.canGoBack()) {
            webView.goBack();
        } else {
            super.onBackPressed();
        }
    }
}