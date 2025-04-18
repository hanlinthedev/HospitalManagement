export interface Doctor {
	name: string;
	specialization_id?: number;
	profile_picture: string;
	specialization: Department;
}

export interface Department {
	id: number;
	name: string;
	icon: string;
}
