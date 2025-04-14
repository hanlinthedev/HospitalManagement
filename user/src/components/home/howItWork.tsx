import arrow from "@/assets/Arrow 1.svg";
import confirm from "@/assets/confirm.svg";
import date from "@/assets/date.svg";
import doctor from "@/assets/doctor.svg";

const HowItWork = () => {
	return (
		<section className="p-4 sm:px-12 mb-4 sm:mb-12">
			<h1 className=" font-semibold text-2xl text-primary">How it works</h1>
			<div className="flex flex-col lg:flex-row justify-between items-center gap-8 lg:gap-4 mt-12 px-12">
				<div>
					<div className="bg-primary w-52 h-52 rounded-full flex flex-col gap-4 justify-center items-center">
						<img src={doctor} alt="" />
					</div>
					<div className="text-xl font-semibold mt-4 w-full text-center opacity-70">
						Choose A Doctor
					</div>
				</div>
				<div className="rotate-90 lg:rotate-0">
					<img src={arrow} alt="" />
				</div>
				<div>
					<div className="bg-primary w-52 h-52 rounded-full flex justify-center items-center">
						<img src={date} alt="" />
					</div>
					<div className="text-xl font-semibold mt-4 w-full text-center opacity-70">
						Pick A Date
					</div>
				</div>
				<div className="rotate-90 lg:rotate-0">
					<img src={arrow} alt="" />
				</div>
				<div>
					<div className="bg-primary w-52 h-52 rounded-full flex justify-center items-center">
						<img src={confirm} alt="" />
					</div>
					<div className="text-xl font-semibold mt-4 w-full text-center opacity-70">
						Confirm Booking
					</div>
				</div>
			</div>
		</section>
	);
};

export default HowItWork;
