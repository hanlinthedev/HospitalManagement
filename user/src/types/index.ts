export interface DoctorData {
    doctor_profile: Doctor;
}

export interface Doctor {
    id: number;
    name: string;
    degree: string;
    specialization_id?: number;
    profile_picture: string;
    specialization: Specialization;
}
export interface Specialization {
    name: string;
}

export interface Department {
    id: number;
    name: string;
    icon: string;
}
