import chooseADoctor from "@/assets/chooseDoctor.png";
import confirmBooking from "@/assets/confirmBooking.png";
import pickADate from "@/assets/pickADate.png";

const HowItWork = () => {
	return (
		<section className="p-4 sm:px-12">
			<h1 className=" font-semibold text-2xl text-primary">How it works</h1>
			<div className="flex flex-col md:flex-row">
				<div>
					<img src={chooseADoctor} alt="" />
				</div>
				<div>
					<img src={pickADate} alt="" />
				</div>
				<div>
					<img src={confirmBooking} alt="" />
				</div>
			</div>
		</section>
	);
};

export default HowItWork;
