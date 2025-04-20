import {
    DoctorDegree,
    DoctorFromWhereDepartment,
    DoctorMainImage,
    DoctorMainName,
    ActionByUserToBook,
    DoctorMain,
} from "../components/doctorsNav/doctorsNavPage";
import { useDoctor } from "@/hooks/useDoctor";

const Doctors = () => {
    const { isLoading, doctors } = useDoctor();
    console.log(doctors, isLoading);
    return (
        <section className="p-4 sm:p-12 flex flex-col gap-[50px]">
            <h1 className=" font-semibold text-2xl text-primary">Doctors</h1>

            <div className="flex flex-row flex-wrap gap-x-[100px] gap-y-[50px] w-full ml-12">
                {doctors?.map(doctor => (
                    <DoctorMain key={doctor.id}>
                        <div className="w-0.5/3">
                            <DoctorMainImage
                                profile_picture={doctor.profile_picture}
                            />
                        </div>
                        <div className="flex flex-col w-2/3">
                            <DoctorMainName name={doctor.name} />
                            <DoctorDegree degree={doctor.degree} />
                            <DoctorFromWhereDepartment
                                specialization={{
                                    name: doctor.specialization.name,
                                }}
                            />
                        </div>
                        <ActionByUserToBook />
                    </DoctorMain>
                ))}
            </div>
        </section>
    );
};

export default Doctors;
