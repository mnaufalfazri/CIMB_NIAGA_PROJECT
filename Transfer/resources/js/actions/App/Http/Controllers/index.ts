import Internal from './Internal'
import DashboardController from './DashboardController'
import MutasiController from './MutasiController'
import Settings from './Settings'
const Controllers = {
    Internal: Object.assign(Internal, Internal),
DashboardController: Object.assign(DashboardController, DashboardController),
MutasiController: Object.assign(MutasiController, MutasiController),
Settings: Object.assign(Settings, Settings),
}

export default Controllers