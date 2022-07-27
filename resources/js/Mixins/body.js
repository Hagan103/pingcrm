export default {
    methods: {
        getBodyMorphTargetInfluences(mesh, body) {
            if (!mesh) {
                return;
            }

            var fat = body.body_fat_percentage / 100;
            var height = body.height;
            var weigh = body.weight;
            var age = body.age
            let fatInfluence = (fat * 2);


            mesh.morphTargetInfluences[0] = 0
            mesh.morphTargetInfluences[1] = 0;
            mesh.morphTargetInfluences[2] = 0;
            mesh.morphTargetInfluences[3] = 0;
            mesh.morphTargetInfluences[4] = 0;

            if (fatInfluence >= 0.5) {
                mesh.morphTargetInfluences[0] = (fatInfluence - 0.5) * 2;
            } else {
                mesh.morphTargetInfluences[4] = (Math.abs(fatInfluence - 0.5) * 2);
                // mesh.morphTargetInfluences[4] = (Math.abs(fatInfluence - 0.5) * 2) * 1.5;
            }

            mesh.morphTargetInfluences[3] = age / 100;

            let m2 = height / 100;
            let ffm = weigh * (1 - (fat));
            let ffmi = ffm / (m2 * m2);
            mesh.morphTargetInfluences[2] = (ffmi / 100) * 3;

        }
    }
}

