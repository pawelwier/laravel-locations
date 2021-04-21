// Method stolen from StackOverflow
export const getDistanceFromLatLonInKm = (point1, point2) => {
    const lat1 = point1.latitude
    const lon1 = point1.longitude
    const lat2 = point2.latitude
    const lon2 = point2.longitude
    const R = 6371; // Radius of the earth in km
    const dLat = deg2rad(lat2 - lat1); // deg2rad below
    const dLon = deg2rad(lon2 - lon1);
    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(deg2rad(lat1)) *
            Math.cos(deg2rad(lat2)) *
            Math.sin(dLon / 2) *
            Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    const d = R * c; // Distance in km
    return Math.floor(d);
}

// Method stolen from StackOverflow
const deg2rad = (deg) => {
    return deg * (Math.PI / 180);
}

export const getDirectionFromLatLonInKm = (point1, point2) => {
    const lat1 = point1.latitude
    const lon1 = point1.longitude
    const lat2 = point2.latitude
    const lon2 = point2.longitude

    let sn = lat2 > lat1 ? 'North' : lat1 > lat2 ? 'South' : null;
    let ew = lon2 > lon1 ? 'East' : lon1 > lon2 ? 'West' : null;

    return `${sn}-${ew}`
}