import { Mail, MapPin, Phone } from "lucide-react";
const Footer = () => {
	return (
		<footer className="bg-primary-foreground py-8 sm:py-12 px-4 sm:px-16">
			<div className="max-w-6xl mx-auto">
				<div className="flex flex-col md:flex-row justify-center md:justify-between gap-8">
					<div className="space-y-6 text-gray-700 text-center md:text-start">
						<h2 className="text-2xl font-bold mb-8">
							Contact & Emergency Info
						</h2>
						<div className="flex justify-center md:justify-start items-center gap-4">
							<Phone size={24} className="text-gray-700" />
							<span className="text-lg">+959663645777</span>
						</div>
						<div className="flex justify-center md:justify-start items-center gap-4">
							<MapPin size={24} className="text-gray-700" />
							<span className="text-lg">Thida Street, Tarmwe, Yangon</span>
						</div>

						<div className="flex justify-center md:justify-start items-center gap-4">
							<Mail size={24} className="text-gray-700" />
							<span className="text-lg">cozyhospital@gmail.com</span>
						</div>
					</div>

					<div className="w-3/4 md:w-1/2 h-80 rounded-lg mx-auto md:mx-0 overflow-hidden">
						{/* Map component - using an iframe to embed Google Maps */}
						<iframe
							src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15278.099008624503!2d96.16113671851924!3d16.80746264019038!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30c1ec8944a210d7%3A0x799c5f5355dbbacb!2sTarmwe%2C%20Yangon!5e0!3m2!1sen!2smm!4v1713104456863!5m2!1sen!2smm"
							className="w-full h-full border-0"
							allowFullScreen
							loading="lazy"
							referrerPolicy="no-referrer-when-downgrade"
							title="Location Map"
						></iframe>
					</div>
				</div>
			</div>
		</footer>
	);
};

export default Footer;
