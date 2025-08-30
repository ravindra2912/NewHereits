/**
 * @format
 */

import { AppRegistry } from 'react-native';
import App from './App';
import WebView from './src/WebViews';
import { name as appName } from './app.json';

AppRegistry.registerComponent(appName, () => WebView);
