import confirm from "@/assets/confirm.svg";
import date from "@/assets/date.svg";
import doctor from "@/assets/doctor.svg";

const HowItWork = () => {
	return (
		<section className="p-4 sm:px-12">
			<h1 className=" font-semibold text-2xl text-primary">How it works</h1>
			<div className="flex flex-col md:flex-row justify-between items-center gap-4 mt-12 px-12">
				<div>
					<div className="bg-primary w-52 h-52 rounded-full flex justify-center items-center">
						<img src={doctor} alt="" />
					</div>
				</div>
				<div>
					<div className="bg-primary w-52 h-52 rounded-full flex justify-center items-center">
						<img src={date} alt="" />
					</div>
				</div>
				<div>
					<div className="bg-primary w-52 h-52 rounded-full flex justify-center items-center">
						<img src={confirm} alt="" />
					</div>
				</div>
			</div>
		</section>
	);
};

export default HowItWork;
