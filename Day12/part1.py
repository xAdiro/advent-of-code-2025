def part1():
    with open("example.txt", "r") as f:
        file = f.read().splitlines()

    presents_end = list(
        filter(lambda x: x[1].strip() == "", enumerate(file)))[-1][0]

    presents_rotations = []

    for present in zip(file[1:presents_end:5], file[2:presents_end:5], file[3:presents_end:5]):
        presents_rotations.append(get_rotations(present))

    spaces = [[int(y) for y in x[:x.find(":")].split("x")]
              for x in file[presents_end+1:]]

    present_ids_used = [[int(y) for y in x[x.find(":")+2:].split(" ")]
                   for x in file[presents_end+1:]]



def get_rotations(present: tuple[tuple[bool]]) -> set(((int, int), list[tuple[tuple[bool]]])):
    rotations = set()

    rotations.add(present)
    rotations.add(get_h_flip(present))
    rotations.add(get_v_flip(present))

    present90 = get_90_rot(present)
    rotations.add(present90)
    rotations.add(get_h_flip(present90))
    rotations.add(get_v_flip(present90))

    present180 = get_180_rot(present)
    rotations.add(present180)
    rotations.add(get_v_flip(present180))
    rotations.add(get_h_flip(present180))

    present270 = get_270_rot(present)
    rotations.add(present270)
    rotations.add(get_v_flip(present270))
    rotations.add(get_h_flip(present270))

    return rotations


def get_v_flip(present):
    return tuple(line[::-1] for line in present)


def get_h_flip(present):
    return tuple(present[::-1])


def get_90_rot(present):
    return tuple("".join(line[i] for line in present[::-1]) for i in range(3))


def get_180_rot(present):
    return get_v_flip(get_h_flip(present))


def get_270_rot(present):
    return get_v_flip(get_h_flip(get_90_rot(present)))


def is_colliding(present_string: tuple[tuple[bool]], start: (int, int), space: list[list[bool]]) -> bool:
    j0, i0 = start

    for i in range(3):
        for j in range(3):
            if present_string[j][i] and space[j+j0][i+i0]:
                return False

    return True


def place_present(present_string: tuple[tuple[bool]], start: (int, int), space: list[list[bool]]) -> bool:
    j0, i0 = start

    for i in range(3):
        for j in range(3):
            space[j0+j][i0+i] = space[j0+j][i0+i] or present_string[j][i]


if __name__ == "__main__":
    part1()
