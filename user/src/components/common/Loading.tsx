import { useEffect, useRef } from "react";

export default function CustomLogoAnimation() {
	const svgRef = useRef<SVGSVGElement>(null);

	useEffect(() => {
		// Get the SVG document from the iframe
		const fetchSVG = async () => {
			try {
				const response = await fetch("/logo.svg");

				const svgText = await response.text();

				// Create a temporary div to parse the SVG
				const div = document.createElement("div");
				div.innerHTML = svgText;

				const svgElement = div.querySelector("svg");
				if (!svgElement || !svgRef.current) return;

				// Copy attributes from the original SVG
				Array.from(svgElement.attributes).forEach((attr) => {
					svgRef.current?.setAttribute(attr.name, attr.value);
				});

				// Copy the content
				svgRef.current.innerHTML = svgElement.innerHTML;

				// Now animate the paths
				const paths = svgRef.current.querySelectorAll("path");

				paths.forEach((path, index) => {
					// Make sure the path has a stroke
					path.setAttribute(
						"stroke",
						path.getAttribute("fill") || "currentColor"
					);
					path.setAttribute("stroke-width", "1");

					const length = path.getTotalLength ? path.getTotalLength() : 100;
					path.style.strokeDasharray = `${length}`;
					path.style.strokeDashoffset = `${length}`;

					path.setAttribute("fill-opacity", "0");

					// Animate stroke
					setTimeout(() => {
						path.animate(
							[{ strokeDashoffset: length }, { strokeDashoffset: 0 }],
							{
								duration: 1000,
								fill: "forwards",
								easing: "ease-out",
							}
						);

						// Animate fill
						setTimeout(() => {
							path.animate([{ fillOpacity: 0 }, { fillOpacity: 1 }], {
								duration: 800,
								fill: "forwards",
								easing: "ease-in",
							});
						}, 800);
					}, index * 100);
				});

				// Pulse animation after everything is drawn
				setTimeout(() => {
					if (svgRef.current) {
						svgRef.current.animate(
							[
								{ transform: "scale(1)" },
								{ transform: "scale(1.05)" },
								{ transform: "scale(1)" },
							],
							{
								duration: 1000,
								iterations: Number.POSITIVE_INFINITY,
								easing: "ease-in-out",
							}
						);
					}
				}, paths.length * 150 + 1800);
			} catch (error) {
				console.error("Error loading SVG:", error);
			}
		};

		fetchSVG();
	}, []);

	return (
		<div className="flex flex-col h-[65vh] items-center justify-center gap-8 p-8">
			<div className="relative w-[200px] h-[200px] flex items-center justify-center">
				<svg
					ref={svgRef}
					width="200"
					height="200"
					viewBox="0 0 24 24"
					className="text-primary"
				></svg>
			</div>
		</div>
	);
}
