import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import { Provider } from "react-redux";
import { BrowserRouter } from "react-router";
import App from "./App.tsx";
import NavigationProgress from "./components/common/NavigationProgress.tsx";
import "./index.css";
import { store } from "./store/index.ts";

const queryClient = new QueryClient({
	defaultOptions: {
		queries: {
			staleTime: 1000 * 60 * 5, // 5 minutes
			retry: 1,
		},
	},
});
createRoot(document.getElementById("root")!).render(
	<StrictMode>
		<Provider store={store}>
			<QueryClientProvider client={queryClient}>
				<BrowserRouter>
					<NavigationProgress />
					<App />
				</BrowserRouter>
			</QueryClientProvider>
		</Provider>
	</StrictMode>
);
