const api = {
    getCategories: async function() {
        try {
            const response = await fetch('http://api.cc.localhost/categories');
            if (!response.ok) {
                console.error('Network response was not ok');
            }
            return JSON.parse(await response.json());
        } catch (error) {
            console.error('Error fetching categories:', error);
            return [];
        }
    },

    getCourses: async function(){
        try{
            let response = await fetch('http://api.cc.localhost/courses');
            if (!response.ok) {
                console.error('Network response was not ok')
            }
            return JSON.parse(await response.json())
        }catch (error){
            console.error('error fetching courses:', error)
        }
    }

};

export default api;