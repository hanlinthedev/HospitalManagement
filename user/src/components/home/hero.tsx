import { CircleCheckBig } from "lucide-react";
import { Button } from "../ui/button";

const Hero = () => {
	return (
		<section className="p-4 sm:p-12">
			<div className="w-full rounded-2xl flex pt-20 h-[594px] bg-cover bg-[url('@/assets/hero.svg')] bg-center bg-fixed bg-repeat relative  ">
				<div className="sticky top-20  bg-white/50  backdrop-blur-[3px] w-full h-[349px] px-4 lg:px-0  py-8">
					<div className="flex flex-row-reverse lg:flex-col gap-4 justify-center lg:justify-between items-center h-full">
						<div className="flex flex-col lg:flex-row justify-around lg:items-center gap-4 w-2/3 sm:w-2/3 lg:w-full ">
							<div className="flex gap-2 items-center text-primary font-semibold text-xs md:text-xl lg:text-2xl">
								<CircleCheckBig strokeWidth={3} />
								Trusted Doctors
							</div>
							<div className="flex gap-2 items-center text-primary font-semibold text-xs md:text-xl lg:text-2xl">
								<CircleCheckBig strokeWidth={3} />
								24/7 Services
							</div>
							<div className="flex gap-2 items-center text-primary font-semibold  text-xs md:text-xl lg:text-2xl">
								<CircleCheckBig strokeWidth={3} />
								Fast Booking
							</div>
						</div>
						<div className="flex flex-col justify-start lg:justify-center items-start lg:items-center gap-4">
							<div className="flex justify-center items-center text-primary font-bold md:text-4xl ">
								Book your appointment in minutes
							</div>
							<Button className="bg-primary text-white  hover:text-primary hover:bg-white transition text-xs sm:text-lg lg:text-2xl font-bold px-4 py-4  sm:px-5 sm:py-5 md:px-6 md:py-8 lg:px-8 lg:py-8 rounded-full mt-2 md:mt-4 lg:mt-8">
								{" "}
								Book Now
							</Button>
						</div>
					</div>
				</div>
			</div>
		</section>
	);
};

export default Hero;
