// NavigationProgressBasic.jsx
import NProgress from "nprogress";
import "nprogress/nprogress.css";
import { useEffect, useRef } from "react";
import { useLocation } from "react-router-dom";

NProgress.configure({ showSpinner: false });
export default function NavigationProgress() {
	const location = useLocation();
	const prevLocation = useRef(location);

	useEffect(() => {
		if (location !== prevLocation.current) {
			NProgress.start();
			prevLocation.current = location;

			// Small timeout to simulate loading, can be replaced with actual data fetching states
			setTimeout(() => {
				NProgress.done();
			}, 300);
		}
	}, [location]);

	return null;
}
