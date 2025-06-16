function loadOneSignalAndInit() {
	// Prevent loading multiple times
	if (document.getElementById('onesignal-sdk')) {
		console.log("OneSignal SDK already loaded");
		return;
	}

	// 1. Create the <script> tag
	const script = document.createElement('script');
	script.id = 'onesignal-sdk';
	script.src = "https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js";
	script.defer = true;

	// 2. Run init code only after script loads
	script.onload = function () {
		console.log("OneSignal SDK loaded");

		// 3. Push init logic into OneSignalDeferred
		window.OneSignalDeferred = window.OneSignalDeferred || [];
		OneSignalDeferred.push(async function (OneSignal) {
			await OneSignal.init({
				appId: window.location.hostname === 'hereits.com'
					? "08672fa6-d212-4b28-8946-9cc22f2030a0"
					: "5ea2682e-14bb-4e60-8771-42fb8d650240",
			});

			const isSupported = await OneSignal.Notifications.isPushSupported();
			if (!isSupported) {
				console.warn("Push not supported");
				return;
			}

			const permission = await OneSignal.Notifications.permission;
			if (permission !== "granted") {
				await OneSignal.Notifications.requestPermission();
			}

			const NotificationUserId = await OneSignal.User.PushSubscription.id;
			$('#notification_token').val(NotificationUserId);
			console.log("Push token:", NotificationUserId);
		});
	};

	script.onerror = function () {
		console.error("Failed to load OneSignal SDK");
	};

	// 4. Append to document
	document.head.appendChild(script);
}

// Example: Call when needed (e.g., on page load or button click)
document.addEventListener('DOMContentLoaded', loadOneSignalAndInit);
