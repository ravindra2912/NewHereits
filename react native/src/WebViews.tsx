import React, { useEffect, useRef, useState } from 'react';
import { SafeAreaView, StyleSheet, View, BackHandler, StatusBar, Image, Linking } from 'react-native';
import { WebView } from 'react-native-webview';
import logo from './asset/logo.png';

export default function WebViews() {
  const webviewRef = useRef(null);
  const [canGoBack, setCanGoBack] = useState(false);
  const [loading, setLoading] = useState(true);
  const [webUrl, setWebUrl] = useState("https://hereits.com"); // ✅ initial URL

  // Handle Android back button
  useEffect(() => {
    const backAction = () => {
      if (canGoBack) {
        webviewRef.current.goBack();
        return true;
      }
      return false;
    };

    const backHandler = BackHandler.addEventListener(
      'hardwareBackPress',
      backAction
    );

    return () => backHandler.remove();
  }, [canGoBack]);

  // Handle incoming deep links
  useEffect(() => {
    Linking.getInitialURL().then((url) => {
      if (url) handleDeepLink(url);
    });

    const subscription = Linking.addEventListener("url", (event) => {
      handleDeepLink(event.url);
    });

    return () => subscription.remove();
  }, []);

  const handleDeepLink = (url) => {
    console.log("Deep link received: ", url);
    if (url.startsWith("https://hereits.com")) {
      setWebUrl(url); // ✅ updates WebView to open this link
    } else {
      Linking.openURL(url); // external links handled outside
    }
  };

  return (
    <>
      <SafeAreaView style={styles.container}>
        {loading && (
          <View style={styles.splash}>
            <Image
              source={logo}
              style={styles.logo}
              resizeMode="contain"
            />
          </View>
        )}
        <WebView
          ref={webviewRef}
          source={{ uri: webUrl }} // ✅ controlled via state
          onNavigationStateChange={(navState) => setCanGoBack(navState.canGoBack)}
          onLoadEnd={() => setLoading(false)}
          style={{ flex: 1 }}
          onShouldStartLoadWithRequest={(request) => {
            if (request.url.startsWith("https://hereits.com")) {
              return true; // load inside WebView
            }
            Linking.openURL(request.url); // external link → open outside
            return false;
          }}
        />
      </SafeAreaView>
    </>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1 },
  splash: {
    ...StyleSheet.absoluteFillObject,
    backgroundColor: '#fff',
    justifyContent: 'center',
    alignItems: 'center',
    zIndex: 10,
  },
  logo: {
    width: 300,
    height: 300,
  },
});
